<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\Expense;
use App\Models\FeeCategory;
use App\Models\School;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        $data['fee_cats'] = FeeCategory::where('school_id', $school_id)->where('status', 1)->get();
        $data['classes'] = Classes::where('school_id', $school_id)->where('status', 1)->get();
        $data['school'] = School::select('id', 'session_id', 'term')->where('id', $school_id)->first();

        if ($request->report == 'fee_collection') {
            $data['report_type'] = 'fee_collection';
            if ($request->class != 'all') {
                $data['students'] = User::select('id', 'first_name', 'middle_name', 'last_name', 'class_id')->where('usertype', 'std')->where('school_id', $school_id)->where('class_id', $request->class)->where('status', 1)->get();
            } else {
                $data['students'] = User::select('id', 'first_name', 'middle_name', 'last_name', 'class_id')->where('usertype', 'std')->where('school_id', $school_id)->where('status', 1)->get();
            }
            if ($data['students']->count() < 1) {
                Toastr::warning('No Students Found in the Selected Class', 'Students Not Found');
                return redirect()->route('billing.report.index');
            }
            return view('accounting.report.index', $data);
        }

        if ($request->report == 'fee_collection_sum') {
            $data['report_type'] = 'fee_collection_sum';
            if ($request->class != 'all') {
                $data['students'] = User::select('id', 'first_name', 'middle_name', 'last_name', 'class_id')->where('usertype', 'std')->where('school_id', $school_id)->where('class_id', $request->class)->where('status', 1)->get();
            } else {
                $data['students'] = User::select('id', 'first_name', 'middle_name', 'last_name', 'class_id')->where('usertype', 'std')->where('school_id', $school_id)->where('status', 1)->get();
            }
            if ($data['students']->count() < 1) {
                Toastr::warning('No Students Found in the Selected Class', 'Students Not Found');
                return redirect()->route('billing.report.index');
            }
            return view('accounting.report.index', $data);

        }

        if ($request->report == 'optional_fees') {
            $data['report_type'] = 'optional_fees';
            return view('accounting.report.index', $data);
        }

        if ($request->report == 'outstanding') {
            $data['report_type'] = 'outstanding';

            if ($request->class == 'all') {
                $data['incompletePayments'] = DB::table('payment_slips')
                    ->join('invoices', 'payment_slips.student_id', '=', 'invoices.student_id')
                    ->select('payment_slips.student_id', DB::raw('SUM(payment_slips.payable + IFNULL(invoices.pre_balance, 0) - IFNULL(payment_slips.discount, 0) - IFNULL(payment_slips.paid, 0)) as remaining'))
                    ->where('payment_slips.session_id', $data['school']->session_id)
                    ->where('payment_slips.school_id', $data['school']->id)
                    ->groupBy('payment_slips.student_id')
                    ->havingRaw('remaining > 0')
                    ->get();
            } else {
                $data['incompletePayments'] = DB::table('payment_slips')
                    ->join('invoices', 'payment_slips.student_id', '=', 'invoices.student_id')
                    ->select('payment_slips.student_id', DB::raw('SUM(payment_slips.payable + IFNULL(invoices.pre_balance, 0) - IFNULL(payment_slips.discount, 0) - IFNULL(payment_slips.paid, 0)) as remaining'))
                    ->where('payment_slips.class_id', $request->class)
                    ->where('payment_slips.session_id', $data['school']->session_id)
                    ->where('payment_slips.school_id', $data['school']->id)
                    ->groupBy('payment_slips.student_id')
                    ->havingRaw('remaining > 0')
                    ->get();
            }
            if ($data['incompletePayments']->count() < 1) {
                Toastr::warning('No Students with Incomplete Payment Found in the Selected Class', 'Students Not Found');
                return redirect()->route('billing.report.index');
            }

            return view('accounting.report.index', $data);
        }

        if ($request->report == 'revenue') {
            $data['report_type'] = 'revenue';

            $data['classes'] = Classes::where('school_id', $data['school']->id)->where('status',1)->get();
            return view('accounting.report.index', $data);
        }

        if ($request->report == 'expenses') {
            $data['report_type'] = 'expenses';

            $expenses = Expense::where('school_id', $data['school']->id)
            ->where('session_id',$data['school']->session_id)
            ->get();

            $data['expensesToday'] = $expenses->filter(function ($expense) {
                return Carbon::parse($expense->date)->isToday();
            })->sum('amount');


            $data['expensesThisWeek'] = $expenses->filter(function ($expense) {
                return Carbon::parse($expense->date)->isBetween(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek());
            })->sum('amount');

            $data['expensesThisMonth'] = $expenses->filter(function ($expense) {
                return Carbon::parse($expense->date)->month === Carbon::now()->month;
            })->sum('amount');

            $data['total'] = $expenses->sum('amount');

            return view('accounting.report.index', $data);
        }



        if (is_int((int) $request->report)) {
            $data['report_type'] = 'one_optional';
            return view('accounting.report.index', $data);
        }

        dd(is_int((int) $request->report));
        dd((int) $request->report);
    }
}
