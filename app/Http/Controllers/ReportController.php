<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

use App\Models\Report;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function update(Request $request, $uid)
    {
        $data = Report::where('attendance_id', $uid);
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
    public function generateReport() {
        $report_data = json_decode(Report::where('attendance_id', $uid)->value('report_result'));
        $attendance = Attendance::where('attendance_id', $uid);
        $start_time = $attendance->start_time;
        $finish_time = Carbon::now();
        
        //calculate duration
        $diff = $finish_time->diffInSeconds($start_time);

        //generate percentage based on heart state
        rp = $this->percentage($report_data->stateCount[0], $diff);
        lp = $this->percentage($report_data->stateCount[1], $diff);
        mp = $this->percentage($report_data->stateCount[2], $diff);
        hp = $this->percentage($report_data->stateCount[3], $diff);
        mxp = $this->percentage($report_data->stateCount[4], $diff);

    }
    private function percentage($up, $bellow) {
        return ($up/$bellow*100);
    }
}
