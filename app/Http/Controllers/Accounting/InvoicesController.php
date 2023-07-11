<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\ClassSection;
use App\Models\FeeStructure;
use App\Models\Invoice;
use App\Models\School;
use App\Models\StudentType;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InvoicesController extends Controller
{
    public function index()
    {

        $school = School::select('id', 'term', 'session_id')
            ->where('id', auth()->user()->school_id)
            ->first();

        $data['classes'] = Classes::select('id', 'name')
            ->where('school_id', $school->id)
            ->where('status', 1)
            ->get();

        $data['invoices'] = Invoice::with(['student', 'class'])
            ->where('school_id', $school->id)
            ->where('session_id', $school->session_id)
            ->where('term', $school->term)
            ->paginate(15);
        $data['studentTypes'] = StudentType::where('school_id', $school->id)->get();

        return view('accounting.invoices.index', $data);

    }

    public function getRecords(Request $request)
    {
        $students = User::select('first_name', 'middle_name', 'last_name', 'id', 'login', 'parent_id')
            ->where('class_id', $request->class_id)
            ->where('usertype', 'std')
            ->where('school_id', auth()->user()->school_id)
            ->where('status', 1)->with('parent')
            ->orderBy('gender', 'desc')
            ->orderBy('first_name')
            ->get();

        $student_types = StudentType::select('id', 'name')->where('school_id', auth()->user()->school_id)->where('status', 1)->get();
        return response()->json([
            'students' => $students,
            'student_types' => $student_types,
        ]);
    }

    public function storeInvoices(Request $request)
    {
        $school = School::select('id', 'session_id', 'term')->where('id', Auth::user()->school_id)->first();

        $regular = FeeStructure::where('school_id', $school->id)
            ->where('class_id', $request->class_id)
            ->where('student_type', 'r')
            ->where('term', $school->term)
            ->sum('amount');
        $transfer = FeeStructure::where('school_id', $school->id)
            ->where('class_id', $request->class_id)
            ->where('student_type', 't')
            ->where('term', $school->term)
            ->sum('amount');
      
        $invoices = Invoice::where('school_id', $school->id)
            ->where('session_id', $school->session_id)
            ->where('term', $school->term)
            ->where('class_id', $request->class_id)
            ->first();
        if ($invoices) {
            return response()->json([
                'status' => 404,
                'message' => 'Invoices has already been generated for the selected',
            ]);
        }

        $rowCount = count($request->student_id);
        if ($rowCount != null) {
            for ($i = 0; $i < $rowCount; $i++) {
                $data = new Invoice();
                $data->school_id = $school->id;
                $data->session_id = $school->session_id;
                $data->term = $school->term;
                $data->class_id = $request->class_id;
                $data->student_id = $request->student_id[$i];
                $data->student_type = $request->student_type[$i];
                $data->pre_balance = $request->pre_balance[$i];

                $number = Invoice::where('school_id', $school->id)
                    ->where('session_id', $school->session_id)
                    ->where('term', $school->term)
                    ->orderBy('id', 'desc')
                    ->first();

                if ($number) {
                    $data->number = $number->number + 1;
                } else {
                    $data->number = 1;
                }

                if ($request->student_type[$i] == 'r' || $request->student_type[$i] == 's') {
                    $data->amount = $regular;
                    if ($regular == 0) {
                        return response()->json([
                            'status' => 404,
                            'message' => 'Fee Structure Not Found for Regular Students',
                        ]);
                    }
                } elseif ($request->student_type[$i] == 't') {
                    $data->amount = $transfer;
                   
                    if ($transfer == 0) {
                        return response()->json([
                            'status' => 404,
                            'message' => 'Fee Structure Not Found for Transfer Students',
                        ]);
                    }
                } else {
                    $payable = FeeStructure::where('school_id', auth()->user()->school_id)
                        ->where('class_id', $request->class_id)
                        ->where('student_type', $request->student_type[$i])
                        ->where('term', $school->term)
                        ->sum('amount');

                    if ($payable == 0) {
                        return response()->json([
                            'status' => 404,
                            'message' => 'Fee Structure Not found for a particular student type.',
                        ]);
                    }
                    $data->amount = $payable;
                }

                if ($request->student_type[$i] == 's') {
                    $data->discount = $regular;
                } else {
                    $data->discount = $request->discount[$i];
                }

                $data->save();
            }
        }

        return response()->json([
            'status' => 200,
            'message' => 'Invoices Generated Successfully',
        ]);
    }

    public function updateInvoices(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'student_type' => 'required',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages(),
            ]);
        }
    
        $data = Invoice::findOrFail($request->id);
        $data->pre_balance = $request->pre_balance;
        $data->student_type = $request->student_type;
    
        if ($request->student_type == 'r' || $request->student_type == 's') {
            $regular = FeeStructure::where('school_id', $data->school_id)
                ->where('class_id', $data->class_id)
                ->where('student_type', 'r')
                ->where('term', $data->term)
                ->sum('amount');
    
            $data->amount = $regular;
        } elseif ($request->student_type == 't') {
            $transfer = FeeStructure::where('school_id', $data->school_id)
                ->where('class_id', $data->class_id)
                ->where('student_type', 't')
                ->where('term', $data->term)
                ->sum('amount');
    
            $data->amount = $transfer;
        } else {
            $payable = FeeStructure::where('school_id', $data->school_id)
                ->where('class_id', $data->class_id)
                ->where('student_type', $request->student_type)
                ->where('term', $data->term)
                ->sum('amount');
    
            $data->amount = $payable;
        }
    
        $data->discount = $request->discount;
        $data->update();
    
        return response()->json([
            'status' => 200,
            'message' => 'Invoice has been Updated Successfully',
        ]);
    }
    
    public function PrintIndex()
    {
        $data['classes'] = Classes::select('id', 'name')->where('school_id', auth()->user()->school_id)->get();
        return view('accounting.invoices.print_index', $data);
    }

    function print(Request $request) {
        $this->validate($request, [
            'class_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
        ]);
        $school = School::with('session')->select('session_id', 'id', 'term', 'name', 'logo', 'username', 'address', 'phone_first', 'phone_second', 'email')->where('id', auth()->user()->school_id)->first();
        $check = Invoice::where('school_id', $school->id)
            ->where('class_id', $request->class_id)
            ->where('session_id', $school->session_id)
            ->where('term', $school->term)
            ->first();
        if (!$check) {
            Toastr::error('Invoices have not been generated for the selected class');
            return redirect()->route('invoices.print.index');
        }
        $class_name = Classes::find($request->class_id)->name;
        return view('pdfs.account.admin.invoices', ['school' => $school, 'class_id' => $request->class_id, 'name' => $request->name, 'phone' => $request->phone, 'class_name' => $class_name]);
    }

    public function bulk_action(Request $request)
    {
        $this->validate($request, [
            'class_id' => 'required',
            'action' => 'required',
        ]);

        $school = School::select('id', 'term', 'session_id')->where('id', auth()->user()->school_id)->first();

        if ($request->action == 'delete') {
            $deletedRows = Invoice::where('class_id', $request->class_id)
                ->where('school_id', auth()->user()->school_id)
                ->where('session_id', $school->session_id)
                ->where('term', $school->term)
                ->delete();
        
            if ($deletedRows > 0) {
                Toastr::success('Invoices Deleted Successfully');
            } else {
                Toastr::info('No rows deleted');
            }
        
            return redirect()->route('invoices.index');
        }
        
    }

    public function fetchData(Request $request)
    {
        $selectedValue = $request->input('value');
        $school_id = Auth::user()->school_id;
        if ($selectedValue === 'regular') {
            $invoices = Invoice::where('student_type', 'r')->where('school_id', $school_id)->get();
        } elseif ($selectedValue === 'transfer') {

            $invoices = Invoice::where('student_type', 't')->where('school_id', $school_id)->get();
        } elseif (strpos($selectedValue, 'type_') === 0) {
            $studentTypeId = substr($selectedValue, 5); 
            $invoices = Invoice::where('student_type', $studentTypeId)->where('school_id', $school_id)->get();
        } elseif (strpos($selectedValue, 'class_') === 0) {
            $classId = substr($selectedValue, 6); 
            $invoices = Invoice::where('class_id', $classId)->where('school_id', $school_id)->get();
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid selected value',
            ]);
        }
    
        $view = view('accounting.invoices.table')->with('invoices', $invoices)->render();
    
        return response()->json([
            'status' => 'success',
            'data' => $view,
        ]);
    }
    
    
    
    
    


}
