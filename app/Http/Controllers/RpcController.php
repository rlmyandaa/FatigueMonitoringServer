<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RpcController extends Controller
{
    public function on(){
        $token = 'Bearer '.$this->getToken();
        $body = ('{"method": "setGpioStatus", "params": {"pin": 5,"enabled": true}}');
        //dd($token);
        $rpc = Http::withHeaders([
            'X-Authorization' => $token,
            'Content-Type' => 'text/plain'
        ])->post('http://localhost:8080/api/plugins/rpc/oneway/c91d1ce0-4756-11eb-9199-39f586681b64', ['method' => 'setActive',
        'params' => array(
            'attendanceId' => 5,
            'fullName' => "l0wpassfilter"
            )
        ]);
        //dd(($rpc));
        return view('home');
    }
    public function off(){
        $token = 'Bearer '.$this->getToken();
        $body = ('{"method": "setGpioStatus", "params": {"pin": 5,"enabled": true}}');
        //dd($token);
        $rpc = Http::withHeaders([
            'X-Authorization' => $token,
            'Content-Type' => 'text/plain'
        ])->get('http://localhost:8080/api/tenant/devices?type=default&pageSize=999&page=0');
        dd(json_decode($rpc)->data);
        $data = array();
        foreach (json_decode($rpc)->data as $d){
            array_push($data, $d->name);
        }
        dd($data);
        return view('home');
    }
    private function getToken(){
        $response = Http::post('http://localhost:8080/api/auth/login', [
            'username' => 'tenant@thingsboard.org',
            'password' => 'tenant',
        ]);
        
        return json_decode($response)->token;
    }
}
