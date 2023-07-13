<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Classes;
use App\Models\Invoice;
use App\Models\Mark;
use App\Models\PaymentRecord;
use App\Models\PaymentSlip;
use App\Models\ProcessedMark;
use App\Models\Profile;
use App\Models\School;
use App\Models\SubjectOffering;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File as File;
use Intervention\Image\Facades\Image;


class StudentsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if($user->usertype == 'teacher' || $user->usertype == 'accountant')
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('form_master_id',$user->id)->where('status',1)->get();
        }else
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('status',1)->get();
        }  
        $data['students'] = User::select('id', 'image','first_name','middle_name','last_name','login','gender','class_id','parent_id','status')
                                ->where('usertype','std')
                                ->where('school_id',$user->school_id)
                                ->where('status',1)
                                ->with(['class','parent'])
                                ->orderBy('gender', 'desc')
                                ->orderBy('first_name')
                                ->paginate(15);
        $data['parents'] = User::select('id','first_name','last_name','login','status')
                                ->where('usertype','parent')
                                ->where('school_id',$user->school_id)
                                ->where('status',1)
                                ->get();
        $data['school'] = School::select('username')->where('id',$user->school_id)->first();
        return view('users.students.index',$data);
    }
    public function paginate()
    {
        $user = auth()->user();
        if($user->usertype == 'teacher' || $user->usertype == 'accountant')
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('form_master_id',$user->id)->where('status',1)->get();
        }else
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('status',1)->get();
        } 
        $data['students'] = User::select('id','image', 'first_name','middle_name','last_name','login','gender','class_id','parent_id','status')
                                    ->where('usertype','std')
                                    ->where('school_id',$user->school_id)
                                    ->where('status',1)
                                    ->with(['class','parent'])
                                    ->orderBy('gender', 'desc')
                                    ->orderBy('first_name')
                                    ->paginate(15);
        $data['school'] = School::select('username')->where('id', $user->school_id)->first();
        return view('users.students.table',$data)->render();
    }

    public function create()
    {
        $user = auth()->user();
        if($user->usertype == 'teacher' || $user->usertype == 'accountant')
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('form_master_id',$user->id)->where('status',1)->get();
        }else
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('status',1)->get();
        } 
        return view('users.students.create', $data);
    }

    public function store(Request $request)
    {
        $rowCount = count($request->first_name);
        if($rowCount != NULL){
            for ($i=0; $i < $rowCount; $i++){
                $data = new User();
                $data->first_name = $request->first_name[$i];
                $data->middle_name = $request->middle_name[$i];
                $data->last_name = $request->last_name[$i];
                $data->gender = $request->gender[$i];
                $data->login = $request->roll_number[$i];
                $data->usertype = 'std';
                $data->class_id = $request->class_id;
                $data->school_id = auth()->user()->school_id;
                $data->password = Hash::make('123');
                $data->save();
            }
        };
        return response()->json([
            'status'=>200,
            'message'=>'Students(s) Registered Successfully',
        ]);
    }
    

    public function sort(Request $request)
    {
        $user = auth()->user();
        if($user->usertype == 'teacher' || $user->usertype == 'accountant')
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('form_master_id',$user->id)->where('status',1)->get();
        }else
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('status',1)->get();
        }        
        
        $data['school'] = School::select('username')->where('id',auth()->user()->school_id)->first();

        if($request->class_id == 'all')
        {
            $data['students'] = User::select('id','image','first_name','middle_name','last_name','login','gender','class_id','parent_id','status')->where('usertype','std')->where('school_id',auth()->user()->school_id)->where('status',1)->with(['class','parent'])->orderBy('gender', 'desc')->orderBy('first_name')->paginate(10000);
        }else{

            $data['students'] = User::select('id','image','first_name','middle_name','last_name','login','gender','class_id','parent_id','status')->where('class_id',$request->class_id)->where('usertype','std')->where('school_id',auth()->user()->school_id)->where('status',1)->with(['class','parent'])->orderBy('gender', 'desc')->orderBy('first_name')->paginate(10000);
        }
      
        if( $data['students']->count() > 0)
        {
            return view('users.students.table', $data)->render();
        }else
        {
            return response()->json([
                'status' => 404,
            ]);
        }
    }

    public function search(Request $request)
    {
    
        $user = auth()->user();
        if($user->usertype == 'teacher' || $user->usertype == 'accountant')
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('form_master_id',$user->id)->where('status',1)->get();
        }else
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('status',1)->get();
        }    

        $data['school'] = School::select('username')->where('id',$user->school_id)->first();

        $data['students'] = User::select('id','image', 'first_name','middle_name','last_name','login','gender','class_id','parent_id','status')
                                ->where('usertype','std')
                                ->where('school_id',$user->school_id)
                                ->where(function($query) use ($request){
                                    $query ->where('login','like','%'.$request['query'].'%')->orWhere('first_name','like','%'.$request['query'].'%')->orWhere('last_name','like','%'.$request['query'].'%');
                                })
                                ->with(['class','parent'])
                                ->orderBy('gender', 'desc')
                                ->orderBy('first_name')
                                ->paginate(10000);

        if( $data['students']->count() )
        {
            return view('users.students.table', $data)->render();
        }else
        {
            return response()->json([
                'status' => 404,
            ]);
        }
       
    }

    public function details(Request $request)
    {

        $student = User::with(['class','parent','profile'])->where('id', $request->student_id)->where('school_id',auth()->user()->school_id)->first();
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

        $student = User::with('profile')->find($request->student_id);
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
        $validator = Validator::make($request->all(), [
            // Add your validation rules here
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }
        
        $school = School::select('username')->where('id', auth()->user()->school_id)->first();
        
        $student = User::find($request->edit_student_id);
        $student->first_name = $request->first_name;
        $student->middle_name = $request->middle_name;
        $student->last_name = $request->last_name;
        $student->login = $request->roll_number;
        $student->parent_id = $request->parent_id;
        $student->gender = $request->gender;
        
        if ($request->file('image') != null) {
            $destination = 'uploads/' . $school->username . '/' . $student->image;
            File::delete($destination);
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
        
            // Use Intervention Image to compress and resize the image
            $image = Image::make($file)
                ->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('jpg', 80); // Set the desired image format and quality
        
            // Save the image to the specified destination
            $image->save('uploads/' . $school->username . '/' . $filename);
        
            $student->image = $filename;
        }
        
        
        $student->update();
        
        // Create or update the student's profile
        $profile = $student->profile ?? new Profile();
        $profile->dob = $request->dob;
        $profile->physical_fitness = $request->physical_fitness;
        
        $student->profile()->save($profile);
        
        return response()->json([
            'status' => 200,
            'message' => 'Student Profile Updated Successfully',
        ]);
        
    }

    public function delete(Request $request){
        $student_id = $request->id;
        User::find($request->id)->delete();
        Invoice::where('student_id', $student_id)->delete();
        Mark::where('student_id', $student_id)->delete();
        Attendance::where('student_id', $student_id)->delete();
        PaymentSlip::where('student_id', $student_id)->delete();
        PaymentRecord::where('student_id', $student_id)->delete();
        ProcessedMark::where('student_id', $student_id)->delete();
        Profile::where('user_id', $student_id)->delete();
        SubjectOffering::where('student_id', $student_id)->delete();
        
       
        return response()->json([
            'status' => 200,
            'message' => 'Student Deleted Successfully'
        ]);
        
    }


}
