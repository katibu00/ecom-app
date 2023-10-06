<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CAScheme;
use App\Models\Classes;
use App\Models\Mark;
use Illuminate\Support\Facades\Validator;


class CASchemeController extends Controller
{
    public function index()
    {
        $data['cas'] = CAScheme::select('id','code','desc','marks','status','class_id')->where('school_id',auth()->user()->school_id)->get();
        $data['classes'] = Classes::with('section')->where('school_id',auth()->user()->school_id)->get();
        return view('settings.ca_scheme.index',$data);
    }

    public function store(Request $request)
    {

        $school_id = auth()->user()->school_id;

        $count = CAScheme::where('school_id', $school_id)->count();

        $data = new CAScheme();
        $data->code = $request->code;
        $data->desc = $request->desc;
        $data->marks = $request->marks;
        $data->school_id = $school_id;
        $data->class_id = implode(',', $request->class_ids);
        $data->save();
            
        return response()->json([
            'status'=>200,
            'count'=>$count,
            'message'=>'CA Scheme(s) Created Successfully',
        ]);
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'code'=>'required',
            'desc'=>'required',
            'marks'=>'required',
        ]);
       
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
      
        $data = CAScheme::findOrFail($request->id);
        $data->code = $request->code;
        $data->desc = $request->desc;
        $data->marks = $request->marks;
        $data->status = $request->status;
        $data->update();

        return response()->json([
            'status'=>200,
            'message'=>'CA Scheme Updated Successfully',
        ]);
    }

    public function delete(Request $request){
      
        $code = CAScheme::find($request->id)->code;
        $check = Mark::where('type', $code)->first();
        if($check)
        {
            return response()->json([
                'status' => 400,
                'message' => 'CA has marks data and hence cannot be deleted'
            ]);
        }
        $data = CAScheme::find($request->id);

        if($data->delete()){

            return response()->json([
                'status' => 200,
                'message' => 'CA Scheme Deleted Successfully'
            ]);

        };
    
    }
}
