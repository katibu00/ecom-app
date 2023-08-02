<?php

namespace App\Http\Controllers\Result;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Mark;
use App\Models\ProcessedMark;
use App\Models\ResultSettings;
use App\Models\School;
use App\Models\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminResultController extends Controller
{
    public function termIndex()
    {
        $data['sessions'] = Session::select('id','name')->where('school_id',auth()->user()->school_id)->get(); 
        $user = auth()->user();

        if($user->usertype == 'teacher' || $user->usertype == 'accountant')
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('form_master_id',$user->id)->where('status',1)->get();
        }else
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('status',1)->get();
        }  
        $data['school'] = School::select('session_id','term')->where('id',auth()->user()->school_id)->first();
        return view('results.termly',$data);
    }

    public function sessionIndex()
    {
        $data['sessions'] = Session::select('id','name')->where('school_id',auth()->user()->school_id)->get(); 
        $user = auth()->user();

        if($user->usertype == 'teacher' || $user->usertype == 'accountant')
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('form_master_id',$user->id)->where('status',1)->get();
        }else
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('status',1)->get();
        }  
        $data['school'] = School::select('session_id','term')->where('id',auth()->user()->school_id)->first();
        return view('results.session',$data);
    }
    public function broadsheetIndex()
    {
        $data['sessions'] = Session::select('id','name')->where('school_id',auth()->user()->school_id)->get(); 
        $user = auth()->user();

        if($user->usertype == 'teacher' || $user->usertype == 'accountant')
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('form_master_id',$user->id)->where('status',1)->get();
        }else
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('status',1)->get();
        }  
        $data['school'] = School::select('session_id','term')->where('id',auth()->user()->school_id)->first();
        return view('results.broadsheet',$data);
    }


    public function termGenerate(Request $request)
    {   
        $this->validate($request, [
            'session_id' => 'required',
            'class_id' => 'required',
            'term' => 'required',
        ]);
    
        $user = Auth::user();
        $school = School::select('id','name','username','email','phone_first','phone_second','address','heading','logo')->where('id', $user->school_id)->first();
    
        $studentsCheck = Mark::select('student_id')->where('class_id', $request->class_id)->where('term', $request->term)->where('school_id', $school->id)->where('session_id', $request->session_id)->groupBy('student_id')->get();
    
        if ($studentsCheck->count() == 0) {
            Toastr::error('No Marks Found', 'Warning');
            return redirect()->back();
        }
    
        $processedMarks = ProcessedMark::where('class_id', $request->class_id)->where('term', $request->term)->where('school_id', $school->id)->where('session_id', $request->session_id)->get();
    
        foreach ($studentsCheck as $student) {
            $ca = Mark::where('student_id', $student->student_id)->where('class_id', $request->class_id)->where('term', $request->term)->where('session_id', $request->session_id)->where('school_id', $school->id)->where('type', '!=', 'exam')->sum('marks');
            $exam = Mark::where('student_id', $student->student_id)->where('class_id', $request->class_id)->where('term', $request->term)->where('school_id', $school->id)->where('session_id', $request->session_id)->where('type', 'exam')->sum('marks');
    
            $data = $processedMarks->where('student_id', $student->student_id)->first();
    
            if (!$data) {
                $data = new ProcessedMark();
                $data->student_id = $student->student_id;
                $data->school_id = $school->id;
                $data->session_id = $request->session_id;
                $data->class_id = $request->class_id;
                $data->term = $request->term;
            }
    
            $data->ca = $ca;
            $data->exam = $exam;
            $data->total = $ca + $exam;
            $data->save();
        }
    
        $students = ProcessedMark::select('student_id','total')->where('class_id',$request->class_id)->where('term',$request->term)->where('school_id',$school->id)->where('session_id',$request->session_id)->groupBy('student_id','total')->orderBy('total','desc')->get();
    
        $session_id = $request->session_id;
        $class_id = $request->class_id;
        $term = $request->term;
    
        $comments = @$request->comments;
        $psychomotor = @$request->psychomotor;
        $next_term = @$request->next_term;
        $date = @$request->date;
    
        return view('pdfs.admin.results.termly', compact('school', 'students', 'class_id', 'term', 'session_id','comments','next_term','date','psychomotor'));
    }
    

    public function settingsIndex()
    {
     
        if(!ResultSettings::where('school_id',auth()->user()->school_id)->first()){
            $new_row = new ResultSettings();
            $new_row->school_id = auth()->user()->school_id;
            $new_row->save();
        }
        $data['settings'] = ResultSettings::where('school_id',auth()->user()->school_id)->first();
        return view('results.settings', $data);
    }

    public function settingsStore(Request $request)
    {
     
        $data = ResultSettings::where('school_id', auth()->user()->school_id)->first();
        if($data)
        {
            $data->show_position = $request->show_position;
            $data->show_attendance = $request->show_attendance;
            $data->show_passport = $request->show_passport;
            $data->show_scores = $request->show_scores;
            $data->break_ca = $request->break_ca;
            $data->withhold = $request->withhold;
            $data->minimun_amount = $request->minimun_amount;
            $data->grading_style = $request->grading_style;
            if($data->update())
            {
                return response()->json([
                    'status' => 200,
                    'message' => 'Result Settings Updated Successfully'
                ]);
            }
        }else
        {
            $data = new ResultSettings();
            $data->school_id = auth()->user()->school_id;
            $data->show_position = $request->show_position;
            $data->show_attendance = $request->show_attendance;
            $data->show_passport = $request->show_passport;
            $data->show_scores = $request->show_scores;
            $data->break_ca = $request->break_ca;
            $data->withhold = $request->withhold;
            $data->minimun_amount = $request->minimun_amount;
            $data->grading_style = $request->grading_style;
            $data->save();
            return response()->json([
                'status' => 200,
                'message' => 'Result Settings Saved Successfully'
            ]);
        }
        
        return response()->json([
            'status' => 404,
            'message' => 'Error Occurred'
        ]);

       
       
    }

    public function sessionGenerate(Request $request)
    {

        $school_id = Auth::user()->school_id;
        $user_id = Auth::user()->id;
        $school = School::with('result_settings')->where('id', $school_id)->first();
        $institution = School::where('id', $school_id)->first();
        $session_id = $request->session_id;

        $users = Mark::select('student_id')->where('class_id', $request->class_id)->where('school_id', $school_id)->where('session_id', $session_id)->groupBy('student_id')->get();


        $class_id = $request->class_id;
        $class_section_id = $request->class_section_id;
        $term = $request->term;

        $students = Mark::select('student_id')->where('class_id', $request->class_id)->where('school_id', $school_id)->where('session_id', $session_id)->groupBy('student_id')->get();

        if ($students->count() == 0) {
            Toastr::warning('No Marks Found', 'Warning');
            return redirect()->back();
        }

        return view('pdfs.admin.results.session', compact('school', 'students', 'class_id', 'class_section_id', 'term', 'school_id', 'session_id'));

    }



    public function broadsheetGenerate(Request $request)
    {

        $school_id = Auth::user()->school_id;
        $user_id = Auth::user()->id;
        $school = School::where('id', $school_id)->first();
        $institution = School::where('id', $school_id)->first();
        $session_id = $request->session_id;

        $studentsCheck = Mark::select('student_id')->where('class_id', $request->class_id)->where('term', $request->term)->where('school_id', $school->id)->where('session_id', $request->session_id)->groupBy('student_id')->get();
    
        if ($studentsCheck->count() == 0) {
            Toastr::error('No Marks Found', 'Warning');
            return redirect()->back();
        }

        $processedMarks = ProcessedMark::where('class_id', $request->class_id)->where('term', $request->term)->where('school_id', $school->id)->where('session_id', $request->session_id)->get();

        foreach ($studentsCheck as $student) {
            $ca = Mark::where('student_id', $student->student_id)->where('class_id', $request->class_id)->where('term', $request->term)->where('session_id', $request->session_id)->where('school_id', $school->id)->where('type', '!=', 'exam')->sum('marks');
            $exam = Mark::where('student_id', $student->student_id)->where('class_id', $request->class_id)->where('term', $request->term)->where('school_id', $school->id)->where('session_id', $request->session_id)->where('type', 'exam')->sum('marks');
    
            $data = $processedMarks->where('student_id', $student->student_id)->first();
    
            if (!$data) {
                $data = new ProcessedMark();
                $data->student_id = $student->student_id;
                $data->school_id = $school->id;
                $data->session_id = $request->session_id;
                $data->class_id = $request->class_id;
                $data->term = $request->term;
            }
    
            $data->ca = $ca;
            $data->exam = $exam;
            $data->total = $ca + $exam;
            $data->save();
        }
    
        $students = ProcessedMark::select('student_id','total')->where('class_id',$request->class_id)->where('term',$request->term)->where('school_id',$school->id)->where('session_id',$request->session_id)->groupBy('student_id','total')->orderBy('total','desc')->get();
    
        if ($students->count() == 0) {
            Toastr::warning('No Marks Found', 'Warning');
            return redirect()->back();
        }
        $class_id = $request->class_id;
        $class_section_id = $request->class_section_id;
        $term = $request->term;

        return view('pdfs.admin.results.broadsheet', compact('school', 'students', 'class_id', 'class_section_id', 'term', 'school_id', 'session_id', 'institution'));

    }

}

