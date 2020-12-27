<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RpcController extends Controller
{
    public function setActive($payload){
        $token = 'Bearer '.$this->getToken();
        //dd($token);
        $url = "http://localhost:8080/api/plugins/rpc/oneway/".$payload->device_id;
        $rpc = Http::withHeaders([
            'X-Authorization' => $token,
            'Content-Type' => 'text/plain'
        ])->post($url, ['method' => 'setActive',
        'params' => array(
            'attendanceId' => $payload->attendance_id,
            'fullName' => $payload->person_name,
            'age' => $payload->age,
            )
        ]);
        //dd(($rpc));

    }
    public function setInactive($payload){
        $token = 'Bearer '.$this->getToken();
        //dd($token);
        $url = "http://localhost:8080/api/plugins/rpc/oneway/".$payload->device_id;
        $rpc = Http::withHeaders([
            'X-Authorization' => $token,
            'Content-Type' => 'text/plain'
        ])->post($url, ['method' => 'setInactive', "params" => ""]);
        //dd(($rpc));

    }

    
    private function getToken(){
        $response = Http::post('http://localhost:8080/api/auth/login', [
            'username' => 'tenant@thingsboard.org',
            'password' => 'tenant',
        ]);
        
        return json_decode($response)->token;
    }
   

}
