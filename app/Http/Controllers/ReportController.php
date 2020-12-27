<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

use App\Models\Report;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function update(Request $request)
    {
        $decoded = json_decode($this->regexjson($request));
        (object) $data = Attendance::where("user_id", $decoded->person_id)->orderBy('attend_date', 'DESC')->first();
        $attendance_id = $data->attendance_id;

        $report = Report::find($attendance_id);
        $t_data = json_decode($report->report_result);
        
        array_push($t_data->hr, $decoded->bpm);
        array_push($t_data->spo2, $decoded->spo2);
        array_push($t_data->temperature, $decoded->temp);
        array_push($t_data->timeState, Carbon::now());
        switch ($decoded->status) {
            case "Relax":
                $t_data->hrStateCount[0] += 1;
                break;
            case "Light":
                $t_data->hrStateCount[1] += 1;
                break;
            case "Moderate":
                $t_data->hrStateCount[2] += 1;
                break;
            case "Hard":
                $t_data->hrStateCount[3] += 1;
                break;
            case "Maximum":
                $t_data->hrStateCount[4] += 1;
                break;
        }
        $report->report_result = json_encode($t_data);
        $report->save();
    }
    public function generateReport($uid) {
        $report_data = json_decode(Report::where('attendance_id', $uid)->value('report_result'));
        $attendanceData = (object) Attendance::where('attendance_id',$uid)->first();
        
        $diff = (new Carbon($attendanceData->finish_time))->diffInRealSeconds(new Carbon($attendanceData->start_time));
        $poolTime = 1;
        $rp = $this->percentage(($report_data->hrStateCount[0])*$poolTime, $diff);
        $lp = $this->percentage(($report_data->hrStateCount[1])*$poolTime, $diff);
        $mp = $this->percentage(($report_data->hrStateCount[2])*$poolTime, $diff);
        $hp = $this->percentage(($report_data->hrStateCount[3])*$poolTime, $diff);
        $mxp = $this->percentage(($report_data->hrStateCount[4])*$poolTime, $diff);
        
        $update = Report::find($uid);
        $u_data = json_decode($update->report_result);

        $u_data->resultSummary = (array(
            "Relax" => $rp." %",
            "Light" => $lp." %",
            "Moderate" => $mp." %",
            "Hard" => $hp." %",
            "Max" => $mxp." %",
        ));
        $u_data->shiftDuration = number_format(($diff/3600), 2, '.', ',')." hours";
        $update->report_result = json_encode($u_data);
        $update->save();
    }

    private function percentage($up, $bellow) {
        return ($up/$bellow*100);
    }

    public function temp(Request $request, $uid)
    {
        $data = Report::where('attendance_id', $request->att);
        $t_data = json_decode($data->report_result);
        array_push($t_data->state, $request->state);
        array_push($t_data->timeState, Carbon::now()->toDateTime());
        switch ($request->state) {
            case "Relax":
                $t_data->stateCount[0] += 1;
                break;
            case "Light":
                $t_data->stateCount[1] += 1;
                break;
            case "Moderate":
                $t_data->stateCount[2] += 1;
                break;
            case "Hard":
                $t_data->stateCount[3] += 1;
                break;
            case "Maximum":
                $t_data->stateCount[4] += 1;
                break;
        }
        $data->report_result = json_encode($t_data);
        $data->save();
    }

    private function regexjson($json){
        $ss = preg_match('/({(?>[^{}]|(?0))*?})/', $json, $matches);
        return $matches[0];
    }
}
