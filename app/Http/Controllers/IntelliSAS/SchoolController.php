<?php

namespace App\Http\Controllers\IntelliSAS;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File as File;
use Illuminate\Support\Facades\Hash;
use Barryvdh\DomPDF\Facade\Pdf;
use Spatie\Multitenancy\Models\Tenant;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SchoolController extends Controller
{

    public function index(){

        $data['schools'] = School::select('name','username','state','service_fee','created_at')->latest()->get();
        return view('intellisas.schools', $data);
    }
    
    public function adminCreate()
    {

        // $data['allData'] = School::all();
        return view('intellisas.new_school');
    }

    public function adminStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:schools,username',
            'school_email' => 'required|email|unique:schools,email',
            'state' => 'required',
            'lga' => 'required',
            'address' => 'required',
            'school_phone' => 'required',
            'website' => 'required',
            'service_fee' => 'required',
            'heading' => 'required',
            'title' => 'required',
            'surname' => 'required',
            'othernames' => 'required',
            'rank' => 'required',
            'admin_email' => 'required|email|unique:users,email',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }
    
        $school = new School();
        $school->fill($request->only([
            'name', 'username', 'motto', 'state', 'lga', 'address',
            'phone_first', 'phone_second', 'email', 'website', 'service_fee'
        ]));
        $school->registrar_id = auth()->user()->id;
    
        if ($request->hasFile('logo')) {
            $destination = 'uploads/logos/';
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move($destination, $filename);
            $school->logo = $filename;
        }
    
        $school->save();
    
        $password = Str::random(8);
        $user = new User();
        $user->fill($request->only([
            'title', 'surname', 'othernames', 'admin_email', 'rank'
        ]));
        $user->first_name = $request->title . ' ' . $request->surname;
        $user->last_name = $request->othernames;
        $user->school_id = $school->id;
        $user->password = Hash::make($password);
        $user->save();
    
        $school->admin_id = $user->id;
        $school->update();
    
        $tenant = new Tenant();
        $user->school_id = $school->id;
        $tenant->name = $request->username;
        $tenant->domain = $request->username . '.localhost';
        $tenant->save();
    
        return response()->json([
            'status' => 201,
            'message' => 'School Registered Successfully',
        ]);
    }
    
    public function getScholDetails(Request $request)
    {
        // $school = School::with(['admin','registrar'])->select('name','username','state', 'lga', 'heading', 'email', 'website', 'phone_first', 'phone_second', 'service_fee','created_at')->where('username', $request->username)->first();
        $school = School::with(['admin','registrar'])->where('username', $request->username)->first();
        $students = User::where('school_id', $school->id)->where('usertype','student')->where('status',1)->get()->count();
        $parents = User::where('school_id', $school->id)->where('usertype','parent')->where('status',1)->get()->count();
        $staffs = User::where('school_id', $school->id)->where('usertype','!=','parent')->where('usertype','!=','student')->where('status',1)->get()->count();
        $registered = $school->created_at->diffForHumans();
        if($school)
        {
            return response()->json([
                'status'=>200,
                'school'=>$school,
                'students'=>$students,
                'parents'=>$parents,
                'staffs'=>$staffs,
                'registered'=>$registered,
            ]);
        }

       
        return response()->json([
            'status'=>400,
            'message'=>'No School Found',
        ]);
    }

    
    public function adminsIndex(){

        $data['admins'] = User::select('first_name','middle_name','last_name','school_id','phone')->where('usertype','admin')->get();
        return view('intellisas.admins', $data);
    }
 
}
