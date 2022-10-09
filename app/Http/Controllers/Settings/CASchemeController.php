<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CAScheme;
use Illuminate\Support\Facades\Validator;


class CASchemeController extends Controller
{
    public function index()
    {
        $data['cas'] = CAScheme::select('id','code','desc','marks','status')->where('school_id',auth()->user()->school_id)->get();
        return view('settings.ca_scheme.index',$data);
    }

    public function store(Request $request)
    {

        $classCount = count($request->code);
        if($classCount != NULL){
            for ($i=0; $i < $classCount; $i++){
                $data = new CAScheme();
                $data->code = $request->code[$i];
                $data->desc = $request->desc[$i];
                $data->marks = $request->marks[$i];
                $data->school_id = auth()->user()->school_id;
                $data->save();
            }
        }

        return response()->json([
            'status'=>200,
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

        $data = CAScheme::find($request->id);

        if($data->delete()){

            return response()->json([
                'status' => 200,
                'message' => 'CA Scheme Deleted Successfully'
            ]);

        };
    
    }
}
