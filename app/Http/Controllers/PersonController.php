<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Person;
use Carbon\Carbon;
use PHPUnit\Util\Json;
use App\Models\Report;
use App\Models\Attendance;

class PersonController extends Controller
{
    public function index() {
        $data = Person::all();
        //dd($data);
        return view('pages.input_person', compact('data'));
    }
    public function submit(Request $request){
        //dd($request);
        //dd((new Carbon($request->dob))->diffInYears(Carbon::now()));
        $person = new Person;
        $person->user_id = $request->user_id;
        $person->full_name = $request->name;
        $person->date_of_birth = $request->dob;
        $person->save();
        //dd((new Carbon($request->dob))->diffInYears(Carbon::now()));
        return redirect('/submit-person');
    }
    public function api_data($id)
    {
        $data = Person::where("user_id", $id)->value("full_name");
        return response()->json($data);
    }
    public function api_alert(Request $request, $id){
        $person = new Person;
        $person->user_id = 33;
        $person->full_name = $id;
        $person->save(); 
    }
    public function delete($id) {
        $data = Person::find($id);
        //dd($data);
        $data->delete();
        return redirect('/submit-person');
    }
    public function report($id) {
        $data = Attendance::where('user_id',$id)->orderBy('attend_date', 'DESC')->paginate(5);
        $name = Person::find($id);
        $name = $name->full_name;
        //dd($data);
        return view('pages.part_report', compact('data', 'name'));
    }
    
}
