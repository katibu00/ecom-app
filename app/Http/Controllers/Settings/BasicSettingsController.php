<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\MonnifyAPISetting;
use App\Models\School;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File as File;


class BasicSettingsController extends Controller
{
    public function index()
    {
        $data['school'] = School::where('id',auth()->user()->school_id)->first();
        $data['sessions'] = Session::select('id','name')->where('school_id',auth()->user()->school_id)->latest()->get();
        return view('settings.school.index', $data);
    }
    public function monnifyIndex()
    {
        $data['monnify'] = MonnifyAPISetting::where('school_id',auth()->user()->school_id)->first();
        return view('settings.monnify.index', $data);
    }

    public function updateBasic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'school_email' => 'required|email',
            'address'=>'required',
            'school_phone' => 'required',
            'website' => 'required',
            'session_id' => 'required',
            'term' => 'required',
            'motto' => 'required',
            
        ]);
       
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }

        $school = School::find(auth()->user()->school_id);
        $school->name = $request->name;
        $school->motto = $request->motto;
        $school->address = $request->address;
        $school->phone_first = $request->school_phone;
        $school->phone_second = $request->alternate_phone;
        $school->email = $request->school_email;
        $school->website = $request->website;
        $school->session_id = $request->session_id;
        $school->term = $request->term;
      

        if ($request->file('logo') != null) {
            $destination = 'uploads/' . $school->username . '/' . $school->logo;
            File::delete($destination);
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/' . $school->username, $filename);
            $school->logo = $filename;
        }

        $school->save();

        return response()->json([
            'status'=>200,
            'message'=>'School Basic Settings Save Successfully',
        ]);
    }

    public function monnifyStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'secret_key'=>'required',
            'public_key' => 'required',
            'contract_code'=>'required',
        ]);
       
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }

        $monnify = MonnifyAPISetting::find(auth()->user()->school_id);
        if($monnify)
        {
            $monnify->public_key = $request->public_key;
            $monnify->secret_key = $request->secret_key;
            $monnify->contract_code = $request->contract_code;
            $monnify->update();
        }else
        {
            $monnify = new MonnifyAPISetting();
            $monnify->school_id = auth()->user()->school_id;
            $monnify->public_key = $request->public_key;
            $monnify->secret_key = $request->secret_key;
            $monnify->contract_code = $request->contract_code;
            $monnify->save();
        }
       

        return response()->json([
            'status'=>200,
            'message'=>'Monnify API Settings Saved Successfully',
        ]);
    }

   
}
