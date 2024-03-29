<?php

namespace App\Http\Controllers;

use App\Models\AssignSubject;
use App\Models\CAScheme;
use App\Models\Classes;
use App\Models\Mark;
use App\Models\MarkSubmit;
use App\Models\School;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MarksController extends Controller
{
    public function create()
    {

        $user = Auth::user();
        $data['school'] = School::where('id', $user->school_id)->first();

        if($user->usertype == 'teacher' || $user->usertype == 'accountant')
        {
            $data['subjects'] = AssignSubject::select('id', 'subject_id', 'class_id', 'designation')->where('school_id', $user->school_id)->where('teacher_id', $user->id)->get();
        }else
        {
            $data['subjects'] = AssignSubject::select('id', 'subject_id', 'class_id', 'designation')->where('school_id', $user->school_id)->get();
        }
        $data['cas'] = CAScheme::where('school_id', $user->school_id)->get();
        return view('marks.create', $data);
    }

    public function getMarks(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'assign_id' => 'required',
            'marks_category' => 'required',
        ]);
    
        if ($validator->fails()) {
            return redirect()->route('marks.create')
                ->withErrors($validator)
                ->withInput();
        }


        $user = Auth::user();
        $school = School::where('id', $user->school_id)->first();
        $term = $school->term;
        $session = $school->session_id;
        $assign = AssignSubject::select('class_id', 'subject_id', 'designation')->where('id', $request->assign_id)->first();
        $data['subjects'] = AssignSubject::where('teacher_id', $user->id)->get();
        $data['subject_id'] = $assign->subject_id;
        $data['class_id'] = $assign->class_id;
        $data['assign_id'] = $request->assign_id;
        $designation = $assign->designation;
        $data['marks_category'] = $request->marks_category;
        if ($request->marks_category != 'exam') {
             $caschema = CAScheme::where('school_id', $user->school_id)->where('id', $request->marks_category)->first();
             $data['max_mark'] = @$caschema->marks;
        } else {
            $data['max_mark'] = 60;
        }

        $data['students'] = Mark::with(['student', 'class'])->where('school_id', $school->id)->where('subject_id', $assign->subject_id)->where('class_id', $assign->class_id)->where('type', $request->marks_category)->where('session_id', $session)->where('term', $term)->get();

        if ($data['students']->count() > 0) {

            $submitted = MarkSubmit::where('school_id', $school->id)
                ->where('session_id', $school->session_id)
                ->where('term', $school->term)
                ->where('class_id', $assign->class_id)
                ->where('subject_id', $assign->subject_id)
                ->where('marks_category', $request->marks_category)
                ->first();
            if ($submitted) {
                $data['submitted'] = 'yes';
            }

            $data['marked'] = Mark::where('school_id', $school->id)
                ->where('session_id', $session)
                ->where('term', $term)
                ->where('class_id', $assign->class_id)
                ->where('subject_id', $assign->subject_id)
                ->where('type', $request->marks_category)
                ->where('marks', '!=', null)->get()->count();

            return view('marks.create', $data);

        } else {
            $data['initial'] = 'yes';
            if ($designation == 0) {

                $data['students'] = User::select('id', 'first_name', 'middle_name', 'last_name', 'login', 'gender', 'class_id')
                    ->where('usertype', 'std')
                    ->where('class_id', $assign->class_id)
                    ->where('school_id', $user->school_id)
                    ->where('status', 1)
                    ->whereHas('subjectOfferings', function ($query) use ($assign) {
                        $query->where('offering', 1)->where('offering', '<>', 0)->where('subject_id', $assign->subject_id);
                    })
                    ->with([
                        'subjectOfferings' => function ($query) use ($assign) {
                            $query->where('offering', 1)->where('offering', '<>', 0)->where('subject_id', $assign->subject_id);
                        },
                    ])
                    ->get();

            } else {
                $data['students'] = User::select('id', 'first_name', 'middle_name', 'last_name', 'login', 'gender', 'class_id', )->where('usertype', 'std')->where('class_id', $assign->class_id)->where('school_id', $user->school_id)->where('status', 1)->with(['class'])->orderBy('gender', 'desc')->orderBy('first_name')->get();
            }
            if ($data['students']->count() == 0) {
                Toastr::error('No Registered students Found');
                return redirect()->back();
            }
            return view('marks.create', $data);
        }

    }

    public function initializeMarks(Request $request)
    {

        $user = Auth::user();
        $school = school::select('id', 'session_id', 'term')->where('id', $user->school_id)->first();

        $check = Mark::where('school_id', $school->id)->where('session_id', $school->session_id)->where('term', $school->term)->where('subject_id', $request->subject_id)->where('class_id', $request->class_id)->where('type', $request->marks_category)->first();

        if ($check) {
            return response()->json([
                'status' => 404,
                'message' => 'Marks have already been Initialized',
            ]);
        }

        $dataCount = count($request->user_id);

        if ($dataCount != null) {
            for ($i = 0; $i < $dataCount; $i++) {
                $data = new Mark();
                $data->school_id = $user->school_id;
                $data->student_id = $request->user_id[$i];
                $data->session_id = $school->session_id;
                $data->term = $school->term;
                $data->class_id = $request->class_id;
                $data->type = $request->marks_category;
                $data->subject_id = $request->subject_id;
                $data->save();
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'Marks Initialized Successfully',
        ]);
    }

    public function saveMarks(Request $request)
    {
        $user = Auth::user();
        $school = school::select('id', 'session_id', 'term')->where('id', $user->school_id)->first();
        $check = Mark::where('school_id', $school->id)->where('session_id', $school->session_id)->where('term', $school->term)->where('student_id', $request->user_id)->where('class_id', $request->class_id)->where('subject_id', $request->subject_id)->where('type', $request->marks_category)->first();

        $marked = Mark::where('school_id', $school->id)
            ->where('session_id', $school->session_id)
            ->where('term', $school->term)
            ->where('subject_id', $request->subject_id)
            ->where('class_id', $request->class_id)
            ->where('type', $request->marks_category)
            ->where('marks', '!=', null)
            ->get()->count();

        if ($check != null) {

            if ($request->marks > $request->max_mark) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Marks must not exceed ' . $request->max_mark,
                ]);
            }
            $check->marks = $request->marks;
            $check->update();

            return response()->json([
                'status' => 200,
                'marked' => $marked,
                'message' => 'Saved as draft',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Not Saved. Please initiliaze marks entry first',
            ]);
        }
    }

    public function submitMarks(Request $request)
    {
        $user = Auth::user();
        $school = school::where('id', $user->school_id)->first();
        $submitexists = MarkSubmit::where('school_id', $school->id)
            ->where('session_id', $school->session_id)
            ->where('term', $school->term)
            ->where('subject_id', $request->subject_id)
            ->where('class_id', $request->class_id)
            ->where('marks_category', $request->marks_category)
            ->first();
        $unmarkedexists = Mark::where('school_id', $school->id)
            ->where('session_id', $school->session_id)
            ->where('term', $school->term)
            ->where('class_id', $request->class_id)
            ->where('subject_id', $request->subject_id)
            ->where('type', $request->marks_category)
            ->where('absent', null)
            ->where('marks', null)
            ->first();

        if ($submitexists) {
            return response()->json([
                'status' => 200,
                'type' => 'error',
                'message' => 'Marks have already been Submitted',
            ]);
        }
        if ($unmarkedexists) {
            return response()->json([
                'status' => 404,
                'type' => 'warning',
                'message' => 'Some student(s) have not been marked. Give marks or mark absent for every student before submitting the marks',
            ]);
        }

        $insert = new MarkSubmit();
        $insert->school_id = $school->id;
        $insert->session_id = $school->session_id;
        $insert->term = $school->term;
        $insert->teacher_id = $user->id;
        $insert->class_id = $request->class_id;
        $insert->subject_id = $request->subject_id;
        $insert->marks_category = $request->marks_category;
        $insert->save();

        return response()->json([
            'status' => 200,
            'type' => 'success',
            'message' => 'Marks submitted successfully',
        ]);
    }

    public function checkAbsentMarks(Request $request)
    {
        $user = Auth::user();
        $school = school::where('id', $user->school_id)->first();
        $check = Mark::where('school_id', $school->id)->where('session_id', $school->session_id)->where('term', $school->term)->where('student_id', $request->user_id)->where('class_id', $request->class_id)->where('subject_id', $request->subject_id)->where('type', $request->marks_category)->first();

        $marked = Mark::where('school_id', $school->id)->where('session_id', $school->session_id)->where('term', $school->term)->where('subject_id', $request->subject_id)->where('class_id', $request->class_id)->where('type', $request->marks_category)->where('marks', '!=', '')->get()->count();

        if ($check != null) {

            $check->marks = 0;
            $check->absent = 'abs';
            $check->update();

            return response()->json([
                'status' => 200,
                'marked' => $marked,
                'type' => 'warning',
                'message' => 'Student marked as absent',
            ]);
        } else {
            return response()->json([
                'status' => 200,
                'type' => 'error',
                'message' => 'Not Save. Please initiliaze marks entry first',
            ]);
        }

    }

    public function uncheckAbsentMarks(Request $request)
    {
        $user = Auth::user();
        $school = school::where('id', $user->school_id)->first();
        $check = Mark::where('school_id', $school->id)->where('session_id', $school->session_id)->where('term', $school->term)->where('class_id', $request->class_id)->where('student_id', $request->user_id)->where('subject_id', $request->subject_id)->where('type', $request->marks_category)->first();
        $marked = Mark::where('school_id', $school->id)->where('session_id', $school->session_id)->where('term', $school->term)->where('class_id', $request->class_id)->where('subject_id', $request->subject_id)->where('type', $request->marks_category)->where('marks', '!=', '')->get()->count();
        if ($check != null) {
            $check->marks = $request->marks;
            $check->absent = null;
            $check->update();

            return response()->json([
                'status' => 200,
                'marked' => $marked,
                'message' => 'Student Marks restored',
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Not Saved. Please initiliaze marks entry first',
            ]);
        }

    }

    public function gradeBookIndex()
    {
        $user = Auth::user();

        if($user->usertype == 'teacher' || $user->usertype == 'accountant')
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('form_master_id',$user->id)->where('status',1)->get();
        }else
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('status',1)->get();
        }     
        return view('marks.grade_book', $data);

    }

    public function gradeGookSearch(Request $request)
    {

        $user = Auth::user();
        $school = School::select('id', 'session_id', 'term')->where('id', $user->school_id)->first();
        $data['term'] = $school->term;
        $data['session'] = $school->session_id;

        $data['classes'] = Classes::select('id', 'name')->where('school_id', $user->school_id)->get();

        $data['school'] = $school;

        $data['students'] = User::where('usertype', 'std')->where('school_id', $user->school_id)->where('class_id', $request->class_id)->get();

        $data['subjects'] = AssignSubject::where('class_id', $request->class_id)->where('class_id', $request->class_id)->where('school_id', $user->school_id)->get();
        $data['class_id'] = $request->class_id;

        if ($data['students']->count() == 0) {
            Toastr::error('No Students found in the selected class', 'Warning');
            return redirect()->route('marks.grade_book.index');
        }

        if ($data['subjects']->count() == 0) {
            Toastr::error('No Subjects have been assigned for the selected class', 'Warning');
            return redirect()->route('marks.grade_book.index');
        }

        return view('marks.grade_book', $data);
    }

    public function submissionIndex()
    {
        $user = Auth::user();

        if($user->usertype == 'teacher' || $user->usertype == 'accountant')
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('form_master_id',$user->id)->where('status',1)->get();
        }else
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('status',1)->get();
        }     
        return view('marks.submissions.index', $data);
    }
    public function submissionSearch(Request $request)
    {
        $user = Auth::user();
        $school = School::select('id', 'session_id', 'term')->where('id', $user->school_id)->first();

        $data['classes'] = Classes::select('id', 'name')->where('school_id', $user->school_id)->get();

        $data['class_id'] = $request->class_id;

        $data['submissions'] = MarkSubmit::with(['subject', 'teacher', 'class'])->where('school_id', $user->school_id)
            ->where('session_id', $school->session_id)
            ->where('term', $school->term)
            ->where('class_id', $request->class_id)
            ->get();

        if ($data['submissions']->count() == 0) {
            Toastr::error('No marks submitted in the selected class', 'Warning');
            return redirect()->back();
        }

        return view('marks.submissions.index', $data);
    }

    public function getCAs(Request $request)
    {
        $subjectId = $request->input('subject_id');
        
        $classId = AssignSubject::where('id', $subjectId)->value('class_id');
        
        $caSchemes = CAScheme::where('class_id', 'LIKE', '%'.$classId.'%')->get();

        return response()->json(['ca_schemes' => $caSchemes]);
    }


}
