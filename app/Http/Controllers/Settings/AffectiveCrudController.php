<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\AffectiveCrud;
use App\Models\PsychomotorGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AffectiveCrudController extends Controller
{
    public function index()
    {
        $data['affectives'] = AffectiveCrud::where('school_id',auth()->user()->school_id)->get();
        return view('settings.affective.index', $data);
    }

    public function store(Request $request)
    {

        $dataCount = count($request->name);
        if($dataCount != NULL){
            for ($i=0; $i < $dataCount; $i++){
                $data = new AffectiveCrud();
                $data->name = $request->name[$i];
                $data->school_id = auth()->user()->school_id;
                $data->save();
            }
        }

        return response()->json([
            'status'=>200,
            'message'=>'Affective Trait(s) Created Successfully',
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
      
        $data = AffectiveCrud::findOrFail($request->id);
        $data->name = $request->name;
        $data->status = $request->status;
        $data->update();

        return response()->json([
            'status'=>200,
            'message'=>'Affective Trait Updated Successfully',
        ]);
    }

    public function delete(Request $request){
        $check = PsychomotorGrade::where('grade_id', $request->id)->first();
        if($check)
        {
            return response()->json([
                'status' => 400,
                'message' => 'Affective Trait has grades and hence cannot be deleted'
            ]);
        }
        $data = AffectiveCrud::find($request->id);

        if($data->delete()){

            return response()->json([
                'status' => 200,
                'message' => 'Affective Trait Deleted Successfully'
            ]);

        };
    
    }
}
