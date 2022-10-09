<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function index() {
        return view('auth.login');
    }

    public function login(Request $request) {

        $validator = Validator::make($request->all(), [
            'login'=>'required|max:191',
            'password'=>'required|max:191'
        ]);
       
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }else{


            
            $login = request()->input('login');
           

            $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'login';
            request()->merge([$fieldType => $login]);


            if(!auth()->attempt($request->only($fieldType, 'password'),$request->remember)){
                return response()->json([
                    'status'=>401,
                    'message'=>'Invalid Credentials'
                ]);
            }

            if(Auth::user()->usertype == 'admin'){
                return response()->json([
                    'status'=>200,
                    'user'=>'admin',
                ]);
            }else if (Auth::user()->usertype == 'student'){
                return response()->json([
                    'status'=>200,
                    'user'=>'student',
                ]);
            }else if (Auth::user()->usertype == 'lecturer'){
                return response()->json([
                    'status'=>200,
                    'user'=>'lecturer',
                ]);
            }else if (Auth::user()->usertype == 'intellisas'){
                return response()->json([
                    'status'=>200,
                    'user'=>'intellisas',
                ]);
            }else if (Auth::user()->usertype == 'applicant'){
                return response()->json([
                    'status'=>200,
                    'user'=>'applicant',
                ]);
            }else{
                return back()->with('status','You are not authorized to access this content');
            }


        }


    }

}
