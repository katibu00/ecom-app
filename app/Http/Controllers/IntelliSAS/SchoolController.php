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
            'name'=>'required',
            'username'=>'required|unique:schools,username',
            'school_email' => 'required|email|unique:schools,email',
            'state'=>'required',
            'lga'=>'required', 
            'address'=>'required',
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
       
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }

        $school = new School();
        $school->name = $request->name;
        $school->username = $request->username;
        $school->motto = $request->motto;
        $school->state = $request->state;
        $school->lga = $request->lga;
        $school->address = $request->address;
        $school->phone_first = $request->school_phone;
        $school->phone_second = $request->alternate_phone;
        $school->email = $request->school_email;
        $school->website = $request->website;
        $school->service_fee = $request->service_fee;
        $school->registrar_id = auth()->user()->id;

        if ($request->file('logo') != null) {

            $destination = 'uploads/logos/' . $school->logo;
            if (File::exists($destination)) {
                File::delete($destination);
            }
            $file = $request->file('logo');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/logos/', $filename);
            $school->logo = $filename;
        }
        $school->save();
        // $id = DB::table('schools')->latest('id')->first();
        $password = Str::random(8);
        $user = new User();
        $user->first_name = $request->title. ' '.$request->surname;
        $user->last_name = $request->othernames;
        $user->email = $request->admin_email;
        $user->school_id = $school->id;
        $user->usertype = $request->rank;
        $user->password = Hash::make($password);
        $user->save();

        $school->admin_id = $user->id;
        $school->update();

        // $service = new Service();
        // $service->school_id = $id->id;
        // $service->save();

        $tenant = new Tenant();
        $tenant->name = $request->username;
        $tenant->domain = $request->username.'.localhost';
        $tenant->save();

        return response()->json([
            'status'=>201,
            'message'=>'School Registered Successfully',
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
 
}
