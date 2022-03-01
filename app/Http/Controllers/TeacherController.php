<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Teacher;

class TeacherController extends Controller
{
    public function index(){
        return view('teacher');
    }

    public function allData(){
        $data = Teacher::orderBy('id','DESC')->get();
        return response()->json($data);
    }

    public function addData(CreateTeacherRequest $request){

        $data = Teacher::insert([
            'name'=>$request->name,
            'subject'=>$request->subject,
            'created_at'=>Carbon::now('l')
        ]);
        return response()->json($data);
    }

    public function editData($id){
        $data = Teacher::findOrFail($id);
        return response()->json($data);
    }

    public function updateData(UpdateTeacherRequest $request ,$id){


        $data = Teacher::findOrFail($id)->update([
            'name'=>$request->name,
            'subject'=>$request->subject,
        ]);

        return response()->json($data);
    }

    public function deleteData($id){
        $data = Teacher::findOrFail($id)->delete();
        return response()->json($data);
    }
}
