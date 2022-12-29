<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\FeeCategory;
use App\Models\FeeStructure;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        $school_id = auth()->user()->school_id;
        $data['fee_cats'] = FeeCategory::where('school_id', $school_id)->where('status', 1)->get();
        $data['classes'] = Classes::where('school_id', $school_id)->where('status', 1)->get();
        // $data['staffs'] = User::all();
        // $data['expenses'] = Expense::where('school_id', auth()->user()->school_id)->orderBy('date','desc')->get();
        return view('accounting.report.index', $data);
    }

    public function generate(Request $request)
    {

        $this->validate($request, [
            'report' => 'required',
            // 'class' => 'required',
            // 'time' => 'required',
        ]);
        $data['report'] = $request->report;
        $data['selected_class'] = $request->class;
        $data['time'] = $request->time;

        $school_id = auth()->user()->school_id;
        $data['fee_cats'] = FeeCategory::where('school_id', $school_id)->where('priority','!=','m')->where('status', 1)->get();
        $data['classes'] = Classes::where('school_id', $school_id)->where('status', 1)->get();
        $data['school'] = School::select('id', 'session_id', 'term')->where('id', $school_id)->first();

        if ($request->report == 'fee_collection') {
            $data['report_type'] = 'fee_collection';
            if ($request->class != 'all') {
                $data['students'] = User::select('id', 'first_name', 'middle_name', 'last_name', 'class_id')->where('class_id', $request->class)->where('status', 1)->get();
               
                $data['mandatory_sum'] = FeeStructure::with('fee_category')
                                        ->whereHas('fee_category', function ($query) {
                                            $query->where('priority', 'm');
                                        })
                                        ->where('school_id', auth()->user()->school_id)
                                        ->where('class_id', $request->class)
                                        ->where('student_type', 'r')->sum('amount');
                return view('accounting.report.index', $data);
            }
        }

        if ($request->report == 'fee_collection_sum') {
            $data['report_type'] = 'fee_collection_sum';
            if ($request->class != 'all') {
                $data['students'] = User::select('id', 'first_name', 'middle_name', 'last_name', 'class_id')->where('class_id', $request->class)->where('status', 1)->get();

                $data['mandatory_sum'] = FeeStructure::with('fee_category')
                    ->whereHas('fee_category', function ($query) {
                        $query->where('priority', 'm');
                    })
                    ->where('school_id', auth()->user()->school_id)
                    ->where('class_id', $request->class)
                    ->where('student_type', 'r')->sum('amount');
                    // dd($data['mandatory_sum']);
                return view('accounting.report.index', $data);
            }
        }

        if ($request->report == 'optional_fees') {
            $data['report_type'] = 'optional_fees';
            return view('accounting.report.index', $data);
        }
        if (is_int((int)$request->report)) {
            $data['report_type'] = 'one_optional';
            return view('accounting.report.index', $data);
        }
        dd(is_int((int)$request->report));
        dd((int)$request->report);
    }
}
