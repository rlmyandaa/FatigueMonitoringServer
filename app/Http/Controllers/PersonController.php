<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Person;
use PHPUnit\Util\Json;

class PersonController extends Controller
{
    public function index() {
        return view('pages.input_person');
    }
    public function submit(Request $request){
        dd($request);
        $person = new Person;
        $person->user_id = Auth()->id();
        $person->full_name = $request->name;
        $person->save();
        return view('pages.input_person');
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
}
