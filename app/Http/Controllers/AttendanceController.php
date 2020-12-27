<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Report;
use App\Models\Person;


use Illuminate\Support\Carbon;
use DateTime;
use Illuminate\Support\Facades\Http;

class AttendanceController extends Controller
{
    public function newAttendance(Request $request)
    {
        $temp = Carbon::now();
        $attendance_uid = $temp->timestamp . $request->user_id . rand(100, 999);

        $data = new Attendance;
        $data->user_id = $request->user_id;
        $data->attend_date = Carbon::now();
        $data->start_time = Carbon::now();
        $data->device_id = $request->device_id;
        $data->attendance_id = $attendance_uid;
        $data->save();

        $report = new Report;
        $report->user_id = $request->user_id;
        //create JSON report
        $report->report_result = $this->createJson($request->device_id, $attendance_uid, Person::where("user_id", $request->user_id)->value("full_name"));
        $report->attendance_id = $attendance_uid;
        $report->save();

        $payload = (object) array(
            "device_id" => $request->device_id,
            "attendance_id" => $attendance_uid,
            "person_name" => Person::where("user_id", $request->user_id)->value("full_name"),
        );
        $this->callRpc("setActive", $payload);

        
    }

    

    public function completeAttendance(Request $request)
    {
        $data = Attendance::find($request->user_id);
        $data->finish_time = Carbon::now();
        $data->save();
        //return response()->json($data["attendance_id"]);
        $payload = (object) array(
            "device_id" => $data->device_id,
        );
        $this->callRpc("setInactive", $payload);
        return redirect()->route('api.report.generate', ['uid' => $data["attendance_id"]]);
    }


    private function callRpc($method, $payload){
        if ($method == "setActive"){
            app('App\Http\Controllers\RpcController')->setActive($payload);
        }
        if ($method == "setInactive"){
            app('App\Http\Controllers\RpcController')->setInactive($payload);
        }
    }
    private function createJson($deviceId, $attendance_id, $name)
    {
        $data = array(
            "deviceID" => $deviceId,
            "attendanceID" => $attendance_id,
            "name" => $name,
            "hr" => array(),
            "spo2" => array(),
            "temperature" => array(),
            "timeState" => array(),
            "hrStateCount" => array(0, 0, 0, 0, 0),
            "resultSummary" => array(),
            "shiftDuration" => "",

        );
        return json_encode($data);
    }
    public function temp(Request $request)
    {
        
    }
}
