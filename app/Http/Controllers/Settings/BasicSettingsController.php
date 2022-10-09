<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
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

   
}
