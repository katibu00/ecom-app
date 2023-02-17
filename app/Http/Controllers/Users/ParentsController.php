<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;


class ParentsController extends Controller
{
    public function index()
    {
        $school_id = auth()->user()->school_id;
        $data['parents'] = User::select('id', 'image','first_name','phone','last_name','login','usertype','status')
                                ->where('usertype','parent')
                                ->where('school_id',$school_id)
                                ->where('status',1)
                                ->orderBy('first_name')
                                ->paginate(15);
        $data['school'] = School::select('username')->where('id',$school_id)->first();
        return view('users.parents.index',$data);
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
        $data['students'] = User::select('id', 'first_name','middle_name','last_name','class_id')->where('usertype','std')->where('school_id',auth()->user()->school_id)->where('status',1)->with(['class'])->orderBy('first_name')->orderBy('last_name')->get();
        return view('users.parents.create', $data);
    }

    public function store(Request $request)
    {
        // dd($request->all());
      
       
        $data = new User();
        $data->first_name = $request->title.' '.$request->first_name;
        $data->last_name = $request->last_name;
        $data->usertype = 'parent';

        $login = $request->login;
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        if($fieldType == 'email')
        {
            $data->email = $request->login;
        }else{
            $data->phone = $request->login;
        }
        $password = Str::random(7, 'abcdefghijklmnopqrstuvwxyz1234567890!@#$%^&*()');

        $data->school_id = auth()->user()->school_id;
        $data->password = Hash::make($password);
        $data->middle_name = $password;
        $data->save();

        $rowCount = count($request->children);
        if($rowCount != NULL){
            for ($i=0; $i < $rowCount; $i++){
                $child =  User::find($request->children[$i]);
                $child->parent_id = $data->id;
                $child->update();
            }
        };
        
        Toastr::success("Parent Registered Successfully");
        return redirect()->route('users.parents.create');
    }
    

    public function sort(Request $request)
    {
        $data['school'] = School::select('username')->where('id',auth()->user()->school_id)->first();

        if($request->sort_staffs == 'all')
        {
            $data['parents'] = User::select('id', 'image','first_name','phone','last_name','login','usertype','status')
                            ->where('usertype','parent')
                            ->where('school_id',auth()->user()->school_id)
                            ->orderBy('first_name')
                            ->paginate(50000);
        }else{

            $data['parents'] = User::select('id', 'image','first_name','phone','last_name','login','usertype','status')
                            ->where('usertype','parent')
                            ->where('school_id',auth()->user()->school_id)
                            ->where('status', $request->sort_staffs)
                            ->orderBy('first_name')
                            ->paginate(50000);
        }
      
        if( $data['parents']->count() > 0)
        {
            return view('users.parents.table', $data)->render();
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


        $data['parents'] = User::select('id', 'image','first_name','phone','last_name','login','usertype','status')
                                ->where(function($query) use ($request){
                                    $query->where('first_name','like','%'.$request['query'].'%')->orWhere('last_name','like','%'.$request['query'].'%');
                                })
                                ->where('usertype','parent')
                                ->where('school_id',$school_id)                              
                                ->orderBy('first_name')
                                ->paginate(100000);

        if( $data['parents']->count() )
        {
            return view('users.parents.table', $data)->render();
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
