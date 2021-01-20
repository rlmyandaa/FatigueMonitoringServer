<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

use App\Models\Report;
use Carbon\Carbon;

use App\Mail\FatigueEmail;
use App\Models\WarningList;
use Illuminate\Support\Facades\Mail;

class ReportController extends Controller
{
    public function update(Request $request)
    {
        $attendance_id = $request->header('attendanceId');
        $decoded = json_decode($this->regexjson($request));
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
    public function generateReport($uid)
    {
        $report_data = json_decode(Report::where('attendance_id', $uid)->value('report_result'));
        $attendanceData = (object) Attendance::where('attendance_id', $uid)->first();

        $diff = (new Carbon($attendanceData->finish_time))->diffInRealSeconds(new Carbon($attendanceData->start_time));
        $totalSampling = count($report_data->timeState);
        $poolTime = 1;
        $rp = $this->percentage(($report_data->hrStateCount[0]), $totalSampling);
        $lp = $this->percentage(($report_data->hrStateCount[1]), $totalSampling);
        $mp = $this->percentage(($report_data->hrStateCount[2]), $totalSampling);
        $hp = $this->percentage(($report_data->hrStateCount[3]), $totalSampling);
        $mxp = $this->percentage(($report_data->hrStateCount[4]), $totalSampling);

        $update = Report::find($uid);
        $u_data = json_decode($update->report_result);

        $statusSummary = "";
        $confirmed = true;
        do {
            if ($mxp > 0) {
                $statusSummary = "You've ever reach a maximum level of your Heart Rate Capacity. You better to see medical professional and have some rest.";
                $warning = new WarningList;
                $warning->name = $u_data->name;
                $warning->attendance_id = $uid;
                $warning->reviewed = false;
                $warning->save();
                $confirmed = false;
                break;
            }
            if ($hp > 0) {
                $statusSummary = "You've reach a hard level of your Heart Rate Capacity. You might've be a bit more tired now. Please have some rest.";
                $warning = new WarningList;
                $warning->name = $u_data->name;
                $warning->attendance_id = $uid;
                $warning->reviewed = false;
                $warning->save();
                $confirmed = false;
                break;
            }
            if ($mp > 0) {
                $statusSummary = "You've reach a moderate level of your Heart Rate Capacity. It should be normal, but don't forget to rest.";
                $confirmed = false;
                break;
            }
            if ($lp > 0 || $rp) {
                $statusSummary = "You're just Fine. Have a Nice Day.";
                $confirmed = false;
                break;
            }
        } while ($confirmed);


        $u_data->resultSummary = (array(
            "Relax" => $rp,
            "Light" => $lp,
            "Moderate" => $mp,
            "Hard" => $hp,
            "Max" => $mxp,
        ));
        $u_data->statusReportSummary = $statusSummary;       
        $u_data->shiftDuration = number_format(($diff / 3600), 2, '.', ',') . " hours";
        $update->report_result = json_encode($u_data);
        $update->save();
        Mail::to("hersyanda.putra@gmail.com")->send(new FatigueEmail($u_data, $attendanceData));
        //return response()->json($totalSampling);
    }

    private function percentage($up, $bellow)
    {
        return (($up / $bellow) * 100);
    }

    public function temp(Request $request, $uid)
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

    private function regexjson($json)
    {
        $ss = preg_match('/({(?>[^{}]|(?0))*?})/', $json, $matches);
        return $matches[0];
    }
}
