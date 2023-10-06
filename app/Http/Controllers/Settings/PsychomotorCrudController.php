<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\PsychomotorCrud;
use App\Models\PsychomotorGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PsychomotorCrudController extends Controller
{
    public function index()
    {
        $data['psychomotors'] = PsychomotorCrud::where('school_id',auth()->user()->school_id)->get();
        return view('settings.psychomotor.index', $data);
    }

    public function store(Request $request)
    {
        $school_id = auth()->user()->school_id;

        $count = PsychomotorCrud::where('school_id', $school_id)->count();


        $dataCount = count($request->name);
        if($dataCount != NULL){
            for ($i=0; $i < $dataCount; $i++){
                $data = new PsychomotorCrud();
                $data->name = $request->name[$i];
                $data->school_id = $school_id;
                $data->save();
            }
        }

        return response()->json([
            'status'=>200,
            'count'=>$count,
            'message'=>'Psychomotor Skill(s) Created Successfully',
        ]);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name'=>'required',
        ]);
       
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
      
        $data = PsychomotorCrud::findOrFail($request->id);
        $data->name = $request->name;
        $data->status = $request->status;
        $data->update();

        return response()->json([
            'status'=>200,
            'message'=>'Psychomotor Skill Updated Successfully',
        ]);
    }

    public function delete(Request $request){
        $check = PsychomotorGrade::where('grade_id', $request->id)->first();
        if($check)
        {
            return response()->json([
                'status' => 400,
                'message' => 'Psychomotor SKill has grades and hence cannot be deleted'
            ]);
        }
        $data = PsychomotorCrud::find($request->id);

        if($data->delete()){

            return response()->json([
                'status' => 200,
                'message' => 'Psychomotor Skill Deleted Successfully'
            ]);

        };
    
    }
}
