<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\FatigueEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\Report;
use App\Models\Attendance;

class MailController extends Controller
{
    public function index(){
        $attendanceData = (object) Attendance::where('attendance_id',1609077581123123893)->first();
        $update = Report::find(1609077581123123893);
        $u_data = json_decode($update->report_result);
        //dd($u_data);
        Mail::to("hersyanda.putra@gmail.com")->send(new FatigueEmail($result, $attendanceData));
        return "Email Sent";
    }
}
