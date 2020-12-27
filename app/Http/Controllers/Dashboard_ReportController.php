<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Attendance;
use App\Models\Person;

class Dashboard_ReportController extends Controller
{
    public function all(){
        $attendance = Attendance::orderBy('attend_date', 'DESC')->get();
        $data = array();
        foreach ($attendance as $d){
            $t_data = array(
                "name" => Person::find($d->user_id)->value('full_name'),
                "attend_time" => $d->attend_date,
                "finish_time" => $d->finish_time,
                "report_url" => route('report.detail', ["uid" => $d->attendance_id]),
            );
            array_push($data, (object) $t_data);
        }
        //dd((object)$data);
        return view('pages.dashboard.report.index', ["data" => (object) $data]);
    }

    public function detail($uid){
        $data = json_decode(Report::find($uid)->value('report_result'));
        $shift = Attendance::find(Report::find($uid)->value('user_id'));
        //dd($shift->attend_date);
        return view('pages.dashboard.report.detail', compact('data', 'shift'));
    }
}
