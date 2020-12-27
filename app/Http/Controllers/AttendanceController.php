<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Report;

use Illuminate\Support\Carbon;
use DateTime;

class AttendanceController extends Controller
{
    public function newAttendance(Request $request){
        $temp = new DateTime();
        $temp = $temp->getTimestamp();
        $attendance_uid = $temp.$request->user_id.rand(100,999);

        //Initialize new Report Placeholder
        $report = new Report;
        $report->user_id = $request->user_id;
        
        //create JSON report
        $report->report_result = $this->createJson($request->device_id, $attendance_uid, Person::where("user_id", $request->user_id)->value("full_name"));
        $report->attendance_id = $attendance_uid;
        $report->save();

        //Create new Attendance List
        $data = new Attendance;
        $data->user_id = $request->user_id;
        $data->attend_date = Carbon::now()->toDateTime();
        $data->start_time = Carbon::now()->toDateTime();
        $data->device_id = $request->device_id;
        $data->attendance_id = $attendance_uid;
        $data->save();
    }

    public function completeAttendance(Request $request){
        $data = Attendance::where('attendance_id', $request->attendance_uid);
        $data->finish_time = Carbon::now()->toDateTime();
        $data->save();
    }

    private function createJson($deviceId, $attendance_id, $name){
        $data = array(
            "deviceID" => "deviceID",
            "attendanceID" => "attendanceID",
            "name" => "it's me",
            "state" => array(),
            "timeState" => array(),
            "stateCount" => array(0,0,0,0,0),
        );
        return json_encode($data);
    }
}
