<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\FeeCategory;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        $school_id = auth()->user()->school_id;
        $data['fee_cats'] = FeeCategory::where('school_id', $school_id)->where('status',1)->get();
        $data['classes'] = Classes::where('school_id', $school_id)->where('status',1)->get();
        // $data['staffs'] = User::all();
        // $data['expenses'] = Expense::where('school_id', auth()->user()->school_id)->orderBy('date','desc')->get();
        return view('accounting.report.index',$data);
    }

    public function generate(Request $request)
    {

            $this->validate($request, [
                'report' => 'required',
                'class' => 'required',
                'time' => 'required',
            ]);
            $data['report'] = $request->report;
            $data['selected_class'] = $request->class;
            $data['time'] = $request->time;

            $school_id = auth()->user()->school_id;
            $data['fee_cats'] = FeeCategory::where('school_id', $school_id)->where('status',1)->get();
            $data['classes'] = Classes::where('school_id', $school_id)->where('status',1)->get();
            $data['school'] = School::select('id','session_id','term')->where('id',$school_id)->first();

            if($request->report == 'fee_collection')
            {
                $data['report_type'] = 'fee_collection';
                if($request->class != 'all')
                {
                    $data['students'] = User::select('id','first_name','middle_name','last_name','class_id')->where('class_id',$request->class)->where('status',1)->get();
                    return view('accounting.report.index',$data);
                }
            }
    }
}
