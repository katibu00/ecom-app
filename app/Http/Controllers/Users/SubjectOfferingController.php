<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\AssignSubject;
use App\Models\Classes;
use App\Models\SubjectOffering;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class SubjectOfferingController extends Controller
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
        return view('users.subjects_offering.index', $data);
    }

    public function getSubjects(Request $request)
    {
        $user = auth()->user();

        if($user->usertype == 'teacher' || $user->usertype == 'accountant')
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('form_master_id',$user->id)->where('status',1)->get();
        }else
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('status',1)->get();
        }  
        $data['subjects'] = AssignSubject::with('subject')->select('subject_id')
            ->where('school_id', $user->school_id)
            ->where('class_id', $request->class_id)
            ->where('designation', 0)
            ->get();

        $data['students'] = User::select('id', 'first_name', 'middle_name', 'last_name')
            ->where('class_id', $request->class_id)
            ->where('school_id', auth()->user()->school_id)
            ->get();
        if ($data['students']->count() < 1) {
            Toastr::error('No Student(s) Found in the Selected Class.');
            return redirect()->route('subjects_offering.index');
        }
        if ($data['subjects']->count() < 1) {
            Toastr::error('No Optional Subject(s) Found in the selected Class.');
            return redirect()->route('subjects_offering.index');
        }

        $data['class_id'] = $request->class_id;
        return view('users.subjects_offering.index', $data);
    }

    public function saveSubjectsOffering(Request $request)
    {
        // dd($request->all());
        $school_id = auth()->user()->school_id;
        $subject_id = $request->input('subject_id');
        $student_id = $request->input('student_id');
        $action = $request->input('action');

        if ($action == 'checked') {
            $subjectOffering = SubjectOffering::where('subject_id', $subject_id)
                ->where('student_id', $student_id)
                ->where('school_id', $school_id)
                ->first();

            if ($subjectOffering) {
                $subjectOffering->offering = 1;
                $subjectOffering->update();
            } else {
                SubjectOffering::create([
                    'subject_id' => $subject_id,
                    'student_id' => $student_id,
                    'school_id' => $school_id,
                    'offering' => 1,
                ]);
            }
        } else {
            $subjectOffering = SubjectOffering::where('subject_id', $subject_id)
                ->where('student_id', $student_id)
                ->where('school_id', $school_id)
                ->first();

            if ($subjectOffering) {
                $subjectOffering->offering = 0;
                $subjectOffering->update();
            }
        }

        return response()->json(['message' => 'Subject Offering updated successfully']);

    }

}
