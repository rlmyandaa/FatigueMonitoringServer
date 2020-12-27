<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Dashboard_DeviceController extends Controller
{
    public function device_list()
    {
        $token = 'Bearer ' . $this->getToken();
        $data = Http::withHeaders([
            'X-Authorization' => $token,
            'Content-Type' => 'text/plain'
        ])->get('http://localhost:8080/api/tenant/devices?type=fatigue&pageSize=999&page=0');
        //$testa = $this->getAccessToken(json_decode($data)->data[1]->id->id);
        //$testb = $this->getAttribute($testa);
        //dd($testb->activeDevice);
        //dd($this->getAttribute($this->getAccessToken('c91d1ce0-4756-11eb-9199-39f586681b64')));
        $device = array();
        foreach (json_decode($data)->data as $d) {
            $temp = array(
                "name" => $d->name,
                "device_id" => $d->id->id,
                "user" => $this->getAttribute($this->getAccessToken($d->id->id, $token), $token)->personName
            );
            if (($this->getAttribute($this->getAccessToken($d->id->id, $token), $token)->activeDevice) == true){
                $temp["state"]="Active";
            }
            else{
                $temp["state"]="Inactive";
            }
            array_push($device, (object) $temp);
        }
        //dd($device);
        return view('pages.dashboard.device.list')->with("data", (object) $device);
    }

    private function getToken()
    {
        $response = Http::post('http://localhost:8080/api/auth/login', [
            'username' => 'tenant@thingsboard.org',
            'password' => 'tenant',
        ]);
        return json_decode($response)->token;
    }

    private function getAttribute($accessToken, $token)
    {
        $url = 'http://localhost:8080/api/v1/' . $accessToken . '/attributes';
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
        $url = 'http://localhost:8080/api/device/' . $deviceId . '/credentials';
        //dd($url);
        $data = Http::withHeaders([
            'X-Authorization' => $token,
            'Content-Type' => 'text/plain'
        ])->get($url);
        return json_decode($data)->credentialsId;
    }
}
