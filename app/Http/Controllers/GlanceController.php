<?php

namespace App\Http\Controllers;

use App\Models\AssignSubject;
use App\Models\Classes;
use App\Models\FeeStructure;
use App\Models\Invoice;
use App\Models\PaymentRecord;
use App\Models\School;
use App\Models\StudentType;
use App\Models\SubjectOffering;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GlanceController extends Controller
{

    public function glance_index()
    {
        $data['school'] = School::where('id', auth()->user()->school_id)->first();
        $data['classes'] = Classes::with(['students', 'assignedSubjects', 'formMaster', 'attendanceRecords'])->where('school_id', auth()->user()->school_id)->get();

        return view('glance.index', $data);
    }

    public function students(Request $request)
    {

        $school_id = Auth::user()->school_id;
        $classId = $request->input('classId');
        $data['name'] = Classes::select('name')->where('id', $classId)->first();

        $data['students'] = User::with('parent')->where('usertype', 'std')->where('school_id', $school_id)->where('class_id', $classId)->get();

        return view('glance.students', $data);
    }

    public function subjects(Request $request)
    {

        $school_id = Auth::user()->school_id;
        $classId = $request->input('classId');
        $data['name'] = Classes::select('name')->where('id', $classId)->first();

        $data['subjects'] = AssignSubject::where('school_id', $school_id)->where('class_id', $classId)->get();

        return view('glance.subjects', $data);
    }

    public function subjectOffering(Request $request)
    {
        $school_id = Auth::user()->school_id;
        $classId = $request->input('classId');

        $data['name'] = Classes::select('name')->where('id', $classId)->first();

        $data['optional_subjects'] = AssignSubject::where('school_id', $school_id)
            ->where('class_id', $classId)
            ->where('designation', 0)
            ->get();

        foreach ($data['optional_subjects'] as $subject) {
            $studentsOffering = SubjectOffering::where('school_id', $school_id)
                ->where('subject_id', $subject->subject_id)
                ->where('offering', 1)
                ->with('student')
                ->get();
            $subject->students = $studentsOffering;
        }

        return view('glance.subject_offering', $data);
    }

    public function feeStructure(Request $request)
    {
        $school_id = Auth::user()->school_id;
        $classId = $request->input('classId');

        $data['name'] = Classes::select('name')->where('id', $classId)->first();

        $fixedStudentTypes = ['r', 't'];
        $data['fixed_fee_structures'] = FeeStructure::where('school_id', $school_id)
            ->where('class_id', $classId)
            ->whereIn('student_type', $fixedStudentTypes)
            ->get();

        $data['studentTypes'] = StudentType::where('school_id', $school_id)->get();
        foreach ($data['studentTypes'] as $studentType) {
            $feeStructure = FeeStructure::where('school_id', $school_id)
                ->where('class_id', $classId)
                ->where('student_type', $studentType->id)
                ->get();

            $studentType->feeStructure = $feeStructure;
        }

        return view('glance.fee_schedule', $data);
    }

    public function invoice(Request $request)
    {

        $school_id = Auth::user()->school_id;
        $classId = $request->input('classId');
        $data['name'] = Classes::select('name')->where('id', $classId)->first();
        $school = School::where('id', $school_id)->first();

        $data['invoices'] = Invoice::where('class_id', $classId)
            ->where('school_id', $school_id)
            ->where('session_id', $school->session_id)
            ->where('term', $school->term)
            ->get();
        return view('glance.invoice', $data);
    }

    public function gradebook(Request $request)
    {

        $school_id = Auth::user()->school_id;
        $school_id = Auth::user()->school_id;
        $institution = School::where('id', $school_id)->first();
        $data['term'] = $institution->term;
        $data['session'] = $institution->session_id;

        $data['children'] = User::where('usertype', 'std')->where('school_id', $school_id)->where('class_id', $request->class_id)->get()->sortBy('first_name');
        $data['school'] = School::where('id', $school_id)->first();
        $data['allData'] = AssignSubject::where('class_id', $request->class_id)->where('school_id', $school_id)->get();
        $data['class_id'] = $request->class_id;

        if ($data['children']->count() == 0) {
            Toastr::error('No Students found in the selected class', 'Warning');
            return redirect()->route('glance.index');
        }

        if ($data['allData']->count() == 0) {
            Toastr::error('No Subjects have been assigned for the selected class', 'Warning');
            return redirect()->route('glance.index');
        }

        return view('glance.gradebook', $data);
    }

    public function feeCollection(Request $request)
    {
        $school_id = Auth::user()->school_id;
        $classId = $request->input('classId');

        $students = User::where('school_id', $school_id)
            ->where('class_id', $classId)
            ->get();

        foreach ($students as $student) {
            $totalDue = Invoice::where('school_id', $school_id)
                ->where('class_id', $classId)
                ->where('student_id', $student->id)
                ->sum(DB::raw('amount + IFNULL(pre_balance, 0) - IFNULL(discount, 0)'));

            $totalPaymentMade = PaymentRecord::where('school_id', $school_id)
                ->where('class_id', $classId)
                ->where('student_id', $student->id)
                ->sum('paid_amount');

            $previousBalance = Invoice::where('school_id', $school_id)
                ->where('class_id', $classId)
                ->where('student_id', $student->id)
                ->orderByDesc('created_at')
                ->value('pre_balance');

            $status = 'N/A';
            if ($totalDue <= 0) {
                $status = 'Paid';
            } elseif ($totalPaymentMade >= $totalDue) {
                $status = 'Full';
            }

            $student->totalDue = $totalDue;
            $student->totalPaymentMade = $totalPaymentMade;
            $student->previousBalance = $previousBalance;
            $student->status = $status;

            $student->paymentRecords = PaymentRecord::where('school_id', $school_id)
                ->where('class_id', $classId)
                ->where('student_id', $student->id)
                ->get();
        }

        return view('glance.fee_collection', compact('students'));
    }

}
