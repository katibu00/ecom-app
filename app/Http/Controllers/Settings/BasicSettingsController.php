<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\MonnifyAPISetting;
use App\Models\School;
use App\Models\Session;
use App\Models\SMSProvider;
use App\Models\Subscription;
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

    public function SMSIndex()
    {
        $data['sms'] = SMSProvider::where('school_id',auth()->user()->school_id)->first();
        return view('settings.sms.index', $data);
    }

    public function updateBasic(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=>'required',
            'school_email' => 'required|email',
            'address'=>'required',
            'school_phone' => 'required',
            'website' => 'nullable',
            'session_id' => 'required',
            'term' => 'required',
            'motto' => 'nullable',
            
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

        $subscriptions = $school->subscriptions();

        if ($subscriptions->count() === 0) {
           
            $subscription = new Subscription();
            $subscription->school_id = $school->id;
            $subscription->session_id = $request->session_id;
            $subscription->term = $school->term;
            $subscription->plan_id = 1;
            $subscription->subscription_type = 'trial';
            $subscription->save();

        } 

        return response()->json([
            'status'=>200,
            'message'=>'School Basic Settings Save Successfully',
        ]);
    }

    public function monnifyStore(Request $request)
    {
        $enableMonnify = $request->input('enable_monnify');
        $schoolId = auth()->user()->school_id;
        
        $data = [
            'enable_monnify' => $enableMonnify,
            'secret_key' => $request->input('secret_key'),
            'public_key' => $request->input('public_key'),
            'contract_code' => $request->input('contract_code'),
        ];
        
        $monnify = MonnifyAPISetting::where('school_id', $schoolId)->first();
    
        if ($enableMonnify) {
            $validator = Validator::make($data, [
                'enable_monnify' => 'required|boolean',
                'secret_key' => 'required',
                'public_key' => 'required',
                'contract_code' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->messages(),
                ]);
            }
    
            if ($monnify) {
                $monnify->update($data);
            } else {
                $monnify = new MonnifyAPISetting($data);
                $monnify->school_id = $schoolId;
                $monnify->save();
            }
        } else {
            if ($monnify) {
                $monnify->enable_monnify = false;
                $monnify->update();
            } else {
                $monnify = new MonnifyAPISetting();
                $monnify->school_id = $schoolId;
                $monnify->save();
            }
        }
    
        return response()->json([
            'status' => 'success',
            'message' => 'Monnify API Settings Saved Successfully',
        ]);
    }
    


    public function saveSMSSettings(Request $request)
    {
        $userSchoolId = auth()->user()->school_id;

        $sms = SMSProvider::where('school_id', $userSchoolId)->first();

        if (!$sms) {
            $sms = new SMSProvider();
            $sms->school_id = $userSchoolId;
        }
        $sms->sms_provider = $request->input('sms_provider');
        $sms->api_token = $request->input('api_token');
        $sms->sender_id = $request->input('sender_id');
        $sms->save();

        return response()->json([
            'status' => 'success',
            'message' => 'SMS Settings Saved Successfully',
        ]);

    }
    
    

   
}
