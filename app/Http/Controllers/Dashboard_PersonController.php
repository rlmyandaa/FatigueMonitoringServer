<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Dashboard_PersonController extends Controller
{
    public function active_list()
    {
        $token = 'Bearer ' .$this->getToken();
        $data = Http::withHeaders([
            'X-Authorization' => $token,
            'Content-Type' => 'text/plain'
        ])->get('http://demo.thingsboard.io/api/tenant/devices?type=fatigue&pageSize=999&page=0');
        $list = array();
        foreach (json_decode($data)->data as $d) {
            if (($this->getAttribute($this->getAccessToken($d->id->id, $token), $token)->activeDevice) == true){
                $temp = array(
                    "device_name" => $d->name,
                    "device_id" => $d->id->id,
                    "person_name" => $this->getAttribute($this->getAccessToken($d->id->id, $token),$token)->personName,
                    "dashUrl" =>  $this->getPublicDashboardUrl($d->name, $token)
                );
                array_push($list, (object) $temp);
            }
            
        }
        //dd($list);
        return view('pages.dashboard.person.list')->with("data", (object) $list);
        //dd();
    }

    private function getToken()
    {
        $response = Http::post('http://demo.thingsboard.io/api/auth/login', [
            'username' => 'yandaa_rlm@upi.edu',
            'password' => 'thingsboard',
        ]);
        return json_decode($response)->token;
    }

    private function getAttribute($accessToken, $token)
    {
        $url = 'http://demo.thingsboard.io/api/v1/' . $accessToken . '/attributes';
        //dd($url);
        $data = Http::withHeaders([
            'X-Authorization' => $token,
            'Content-Type' => 'text/plain'
        ])->get($url);
        //dd(json_decode($data));
        if (empty(json_decode($data, true))) {
            $arr = array(
                "activeDevice" => "",
                "personAttendanceId" => 0,
                "personName" => ""
            );
            return ((object) $arr);
        } else {
            return json_decode($data)->client;
        }
    }

    private function getAccessToken($deviceId, $token)
    {
        
        $url = 'http://demo.thingsboard.io/api/device/' . $deviceId . '/credentials';
        //dd($url);
        $data = Http::withHeaders([
            'X-Authorization' => $token,
            'Content-Type' => 'text/plain'
        ])->get($url);
        return json_decode($data)->credentialsId;
    }

    private function getPublicDashboardUrl($deviceName, $token){
        $dashboardId = $this->getDashboardId($deviceName, $token);
        $publicId = $this->getPublicId($token);
        $url = "http://127.0.0.1:8080/dashboard/".$dashboardId."?publicId=".$publicId;
        return ($url);
    }

    private function getDashboardId($dashboardName, $token){
        $dashboardName = "Fatigue Monitoring : ".$dashboardName;
        $dashboardName = str_replace(' ', "%20", $dashboardName);
        $dashboardName = str_replace(":", "%3A", $dashboardName);
        $url = ("http://demo.thingsboard.io/api/tenant/dashboards?textSearch=".$dashboardName."&pageSize=8&page=0");
        
        //dd($url);
        $data = Http::withHeaders([
            'X-Authorization' => $token,
            'Content-Type' => 'text/plain'
        ])->get($url);
        //dd(json_decode($data)->data[0]->id->id);
        return json_decode($data)->data[0]->id->id;
    }

    private function getPublicId($token){
        $url = "http://demo.thingsboard.io/api/tenant/customers?customerTitle=Public";
        
        
        //dd($url);
        $data = Http::withHeaders([
            'X-Authorization' => $token,
            'Content-Type' => 'text/plain'
        ])->get($url);

        return (json_decode($data)->id->id);
    }
}
