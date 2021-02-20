<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Attendance;
use App\Models\Person;
use App\Models\WarningList;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class Dashboard_ReportController extends Controller
{
    public function all(){
        $attendance = Attendance::orderBy('attend_date', 'DESC')->get();
        //dd($attendance);
        $data = array();
        $num = 1;
        foreach ($attendance as $d){
            $t_data = array(
                "num" => $num++,
                "name" => Person::where('user_id', $d->user_id)->value('full_name'),
                "attend_time" => $d->attend_date,
                "finish_time" => $d->finish_time,
                "report_url" => route('report.detail', ["uid" => $d->attendance_id]),
            );
            array_push($data, (object) $t_data);
        }
        $warning = WarningList::all();
        $data = $this->paginate($data, 15);
        $data->setPath('/dashboard/report');
        //dd($data);
        //dd((object)$data);
        return view('pages.dashboard.report.index', compact('data', 'warning'));
    }

    public function detail($uid){
        $data = json_decode(Report::where('attendance_id', $uid)->value('report_result'));
        //dd($data);
        $shift = Attendance::find(Report::find($uid)->value('user_id'));
        //dd($shift->attend_date);
        return view('pages.dashboard.report.detail', compact('data', 'shift'));
    }
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}
