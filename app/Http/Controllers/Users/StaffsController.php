<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StaffsController extends Controller
{
    public function index()
    {
        $school_id = auth()->user()->school_id;
        $data['staffs'] = User::select('id', 'image','first_name','phone','last_name','login','usertype','status')
                                ->where('usertype','!=','std')
                                ->where('usertype','!=','parent')
                                ->where('usertype','!=','intellisas')
                                ->where('school_id',$school_id)
                                ->where('status',1)
                                ->orderBy('first_name')
                                ->paginate(15);
        $data['school'] = School::select('username')->where('id',$school_id)->first();
        return view('users.staffs.index',$data);
    }
    public function paginate()
    {
        $data['classes'] = Classes::select('id', 'name')->where('school_id',auth()->user()->school_id)->get();
        $data['students'] = User::select('id','image', 'first_name','middle_name','last_name','login','gender','class_id','parent_id','status','address')->where('usertype','std')->where('school_id',auth()->user()->school_id)->where('status',1)->with(['class','parent'])->orderBy('gender', 'desc')->orderBy('first_name')->paginate(15);
        $data['school'] = School::select('username')->where('id',auth()->user()->school_id)->first();
        return view('users.students.table',$data)->render();
    }

    public function create()
    {

        return view('users.staffs.create');
    }

    public function store(Request $request)
    {
        
        $rowCount = count($request->first_name);
        if($rowCount != NULL){
            for ($i=0; $i < $rowCount; $i++){
                $data = new User();
                $data->first_name = $request->title[$i].' '.$request->first_name[$i];
                $data->last_name = $request->last_name[$i];

                $login = $request->login[$i];
                $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
                if($fieldType == 'email')
                {
                    $data->email = $request->login[$i];
                }else{
                    $data->phone = $request->login[$i];
                }
                $password = Str::random(7, 'abcdefghijklmnopqrstuvwxyz1234567890!@#$%^&*()');

                $data->usertype = $request->usertype[$i];
                $data->school_id = auth()->user()->school_id;
                $data->password = Hash::make($password);
                $data->middle_name = $password;
                $data->save();
            }
        };
       Toastr::success("Staffs Registered Successfully");
       return redirect()->route('users.staffs.index');
    }
    

    public function sort(Request $request)
    {
        $data['school'] = School::select('username')->where('id',auth()->user()->school_id)->first();

        if($request->sort_staffs == 'all')
        {
            $data['staffs'] = User::select('id', 'image','first_name','phone','last_name','login','usertype','status')
                            ->where('usertype','!=','std')
                            ->where('usertype','!=','parent')
                            ->where('usertype','!=','intellisas')
                            ->where('school_id',auth()->user()->school_id)
                            ->orderBy('first_name')
                            ->paginate(50000);
        }else{

            $data['staffs'] = User::select('id', 'image','first_name','phone','last_name','login','usertype','status')
                            ->where('usertype','!=','std')
                            ->where('usertype','!=','parent')
                            ->where('usertype','!=','intellisas')
                            ->where('school_id',auth()->user()->school_id)
                            ->where('status', $request->sort_staffs)
                            ->orderBy('first_name')
                            ->paginate(50000);
        }
      
        if( $data['staffs']->count() > 0)
        {
            return view('users.staffs.table', $data)->render();
        }else
        {
            return response()->json([
                'status' => 404,
            ]);
        }
    }

    public function search(Request $request)
    {
    
        $school_id = auth()->user()->school_id;
        $data['school'] = School::select('username')->where('id',$school_id)->first();


        $data['staffs'] = User::select('id', 'image','first_name','phone','last_name','login','usertype','status')
                                ->where(function($query) use ($request){
                                    $query->where('first_name','like','%'.$request['query'].'%')->orWhere('last_name','like','%'.$request['query'].'%');
                                })
                                ->where('usertype','!=','std')
                                ->where('usertype','!=','parent')
                                ->where('usertype','!=','intellisas')
                                ->where('school_id',$school_id)                              
                                ->orderBy('first_name')
                                ->paginate(100000);

        if( $data['staffs']->count() )
        {
            return view('users.staffs.table', $data)->render();
        }else
        {
            return response()->json([
                'status' => 404,
            ]);
        }
       
    }

    public function details(Request $request)
    {

        $student = User::with(['class','parent'])->where('id', $request->student_id)->where('school_id',auth()->user()->school_id)->first();
        $registered = $student->created_at->diffForHumans();
        $school_name = School::select('username')->where('id',auth()->user()->school_id)->first();
       
        if($student)
        {
            return response()->json([
                'status'=>200,
                'student'=>$student,
                'registered'=>$registered,
                'school_name'=>$school_name,
            ]);
        }
       
        return response()->json([
            'status'=>400,
            'message'=>'No User Found',
        ]);
    }

 

 

    public function getStudentDetails(Request $request)
    {

        $student = User::find($request->student_id);
        $school_username = School::select('username')->where('id',auth()->user()->school_id)->first();

        if($student){
            return response()->json([
                'student' => $student,
                'school_username' => $school_username,
                'status' => 200,
            ]);  
        }

        return response()->json([
            'subjects' => 'Student Not Found',
            'status' => 404,
        ]);
    }

    public function editStudent(Request $request)
    {
        // return $request->all();
        $validator = Validator::make($request->all(), [
            // 'name'=>'required',
            // 'school_email' => 'required|email',
            // 'address'=>'required',
            // 'school_phone' => 'required',
            // 'website' => 'required',
            // 'session_id' => 'required',
            // 'term' => 'required',
            // 'motto' => 'required',
            
        ]);
       
        if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
        }
        $school = School::select('username')->where('id',auth()->user()->school_id)->first();
       
        $student = User::find($request->edit_student_id);
        $student->first_name = $request->first_name;
        $student->middle_name = $request->middle_name;
        $student->last_name = $request->last_name;
        $student->login = $request->roll_number;
        $student->parent_id = $request->parent_id;
        $student->gender = $request->gender;
        $student->dob = $request->dob;
      

        if ($request->file('image') != null) {
            $destination = 'uploads/' . $school->username . '/' . $student->image;
            File::delete($destination);
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move('uploads/' . $school->username, $filename);
            $student->image = $filename;
        }

        $student->update();

        return response()->json([
            'status'=>200,
            'message'=>'Student Profile Updated Successfully',
        ]);
    }
}
