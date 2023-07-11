<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Mark;
use App\Models\School;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class SessionsController extends Controller
{
    public function index()
    {
        $data['sessions'] = Session::select('id', 'name')->where('school_id',auth()->user()->school_id)->latest()->get();
        return view('settings.sessions.index', $data);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('sessions')->where(function ($query) {
                    return $query->where('school_id', auth()->user()->school_id);
                })
            ],
        ]);
       
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
      
        $session = new Session();
        $session->name = $request->name;
        $session->school_id = auth()->user()->school_id;
        $session->save();

        $count = Session::where('school_id', auth()->user()->school_id)->count();
        $school = School::where('id', auth()->user()->school_id)->first();
        
        if (!$school->session_id) {
            $school->session_id = $session->id;
            $school->save();
        }


        return response()->json([
            'status' => 201,
            'message' => 'Session Created Successfully',
            'count' => $count,
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
      
        $session = Session::findOrFail($request->id);
        $session->name = $request->name;
        $session->update();

        return response()->json([
            'status'=>200,
            'message'=>'Session Updated Successfully',
        ]);
    }

    public function delete(Request $request){

        $marks = Mark::where('session_id', $request->id)->first();
        if($marks)
        {
            return response()->json([
                'status' => 400,
                'message' => 'Sesion has marks data and hence cannot be deleted'
            ]);
        }
        $data = Session::find($request->id);

        

        if($data->delete()){

            return response()->json([
                'status' => 200,
                'message' => 'Session Deleted Successfully'
            ]);

        };
    
    }
}
