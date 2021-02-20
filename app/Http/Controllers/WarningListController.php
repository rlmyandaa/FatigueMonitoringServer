<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WarningList;

class WarningListController extends Controller
{
    public function list(){
        $data = WarningList::all();
        //  dd($data);
        return view('pages.dashboard.warning.index', ["data" => $data]);
    }
    public function reviewed($uid){
        $data = WarningList::find($uid);
        $data->reviewed = true;
        $data->save();
        return redirect('/dashboard/report');
    }
}
