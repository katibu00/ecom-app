<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Classes;
use App\Models\FeeCategory;
use App\Models\FeeStructure;
use App\Models\School;
use App\Models\StudentType;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeeStructuresController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        $school = School::select('term')->where('id', $user->school_id)->first();

        $fees = FeeCategory::select('id', 'name')
            ->where('school_id', $user->school_id)
            ->where('status', 1)
            ->orderBy('name')
            ->get();

        $classes = Classes::select('id', 'name')
            ->where('school_id', $user->school_id)
            ->get();

        $student_types = StudentType::select('id', 'name')
            ->where('school_id', $user->school_id)
            ->where('status', 1)
            ->get();

        $feeStructure = [];

        foreach ($classes as $key => $class) {
            $row = [
                'class' => $class,
                'regular' => null,
                'transfer' => null,
                'studentTypes' => [],
            ];

            $regular = FeeStructure::where('school_id', $user->school_id)
                ->where('class_id', $class->id)
                ->where('student_type', 'r')
                ->where('term', $school->term)
                ->first();

            if ($regular) {
                $row['regular'] = $regular;
            }

            $transfer = FeeStructure::where('school_id', $user->school_id)
                ->where('class_id', $class->id)
                ->where('student_type', 't')
                ->where('term', $school->term)
                ->first();

            if ($transfer) {
                $row['transfer'] = $transfer;
            }

            foreach ($student_types as $student_type) {
                $structured = FeeStructure::where('school_id', $user->school_id)
                    ->where('class_id', $class->id)
                    ->where('student_type', $student_type->id)
                    ->where('term', $school->term)
                    ->first();

                if ($structured) {
                    $row['studentTypes'][$student_type->id] = $structured;
                }
            }

            $feeStructure[] = $row;
        }

        return view('settings.fee_structure.index', compact('feeStructure', 'fees', 'classes', 'student_types', 'school'));
    }

    public function changeTerm(Request $request)
    {
        $term = $request->input('term');

        $schoolId = auth()->user()->school_id;
        $feeStructure = [];

        $classes = Classes::select('id', 'name')->where('school_id', $schoolId)->get();
        $studentTypes = StudentType::select('id', 'name')->where('school_id', $schoolId)->where('status', 1)->get();

        foreach ($classes as $class) {
            $row = [
                'class' => $class,
                'regular' => null,
                'transfer' => null,
                'studentTypes' => [],
            ];

            $regular = FeeStructure::where('school_id', $schoolId)
                ->where('class_id', $class->id)
                ->where('student_type', 'r')
                ->where('term', $term)
                ->first();

            if ($regular) {
                $row['regular'] = $regular;
            }

            $transfer = FeeStructure::where('school_id', $schoolId)
                ->where('class_id', $class->id)
                ->where('student_type', 't')
                ->where('term', $term)
                ->first();

            if ($transfer) {
                $row['transfer'] = $transfer;
            }

            foreach ($studentTypes as $studentType) {
                $fee = FeeStructure::where('school_id', $schoolId)
                    ->where('class_id', $class->id)
                    ->where('student_type', $studentType->id)
                    ->where('term', $term)
                    ->first();

                if ($fee) {
                    $row['studentTypes'][$studentType->id] = $fee;
                }
            }

            $feeStructure[] = $row;
        }

        $data = [
            'feeStructure' => $feeStructure,
            'student_types' => $studentTypes,
        ];

        return view('settings.fee_structure.table', $data)->render();

    }

    public function delete(Request $request)
    {

        $data = FeeStructure::find($request->id);

        if ($data->delete()) {

            return response()->json([
                'status' => 200,
                'message' => 'Fee Category Unassigned Successfully',
            ]);

        };

    }

    public function details(Request $request)
    {
        $school_id = auth()->user()->school_id;
        $student_type = '';

        if ($request->std_type == 'Regular') {
            $student_type = 'r';
        } elseif ($request->std_type == 'Transfer') {
            $student_type = 't';
        } else {
            $student_type = StudentType::where('school_id', $school_id)->where('name', $request->std_type)->first()->id;
        }

        $fees = FeeStructure::with('fee_category')
            ->where('school_id', $school_id)
            ->where('class_id', $request->class_id)
            ->where('student_type', $student_type)
            ->where('term', $request->term)
            ->select('fee_category_id', 'priority', 'amount')
            ->get();

        return response()->json([
            'status' => 200,
            'fees' => $fees,
        ]);
    }

    public function edit(Request $request)
    {
        $school_id = auth()->user()->school_id;
        $student_type = '';
        $studentType = '';

        if ($request->student_type == 'regular') {
            $student_type = 'r';
            $studentType = 'Regular';
        } elseif ($request->student_type == 'transfer') {
            $student_type = 't';
            $studentType = 'Transfer';
        } else {
            $row = StudentType::where('school_id', $school_id)->where('id', $request->student_type)->select('id', 'name')->first();
            $studentType = $row->name;
            $student_type = $row->id;
        }

        $class_id = $request->query('class_id');
        $term = $request->query('term');

        $class = Classes::find($class_id);
        $termName = '';
        if ($term == 1) {
            $termName = 'First';
        } elseif ($term == 2) {
            $termName = 'Second';
        } elseif ($term == 3) {
            $termName = 'Third';
        } else {
            $termName = 'Unknown Term';
        }

        $data['fees'] = FeeCategory::select('id', 'name')->where('school_id', $school_id)->get();
        $data['rows'] = FeeStructure::with('fee_category')
            ->select('id', 'fee_category_id', 'amount', 'priority', 'status')
            ->where('school_id', $school_id)
            ->where('class_id', $class_id)
            ->where('student_type', $student_type)
            ->where('term', $term)
            ->get();

        // Calculate totals
        $totals = [
            'mandatory' => $data['rows']->where('status', 1)->where('priority', 'm')->sum('amount'),
            'recommended' => $data['rows']->where('status', 1)->where('priority', 'r')->sum('amount'),
            'optional' => $data['rows']->where('status', 1)->where('priority', 'o')->sum('amount'),
            'total' => $data['rows']->where('status', 1)->sum('amount'),
        ];

        $data['student_type'] = $student_type;
        $data['class_id'] = $class_id;
        $data['totals'] = $totals; // Pass the totals to the view
        $data['class'] = $class;
        $data['termName'] = $termName;
        $data['studentType'] = $studentType;

        return view('settings.fee_structure.edit', $data);
    }

    public function update(Request $request)
    {
        $data = FeeStructure::find($request->id);
        $data->amount = $request->amount;
        $data->priority = $request->priority;
        $data->status = $request->status;
        $data->update();

        return response()->json([
            'status' => 200,
            'message' => 'Fee Structure Updated Successfully',
        ]);

    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required',
            'student_type' => 'required',
            'term' => 'required',
            'fee_category_id.*' => 'required',
            'amount.*' => 'required',
            'priority.*' => 'required',
        ]);

        $schoolId = Auth::user()->school_id;
        $classId = $request->input('class_id');
        $studentType = $request->input('student_type');
        $term = $request->input('term');

        $insertedRecords = [];
        $skippedRecords = [];

        $feeCategoryIds = $request->input('fee_category_id');
        $amounts = $request->input('amount');
        $priorities = $request->input('priority');

        for ($i = 0; $i < count($feeCategoryIds); $i++) {
            // Check if the fee structure already exists for the selected class, student type, term, and fee category
            $existingRecord = FeeStructure::where('school_id', $schoolId)
                ->where('class_id', $classId)
                ->where('student_type', $studentType)
                ->where('term', $term)
                ->where('fee_category_id', $feeCategoryIds[$i])
                ->first();

            if ($existingRecord) {
                $skippedRecords[] = $feeCategoryIds[$i];
                continue;
            }

            $feeStructure = new FeeStructure();
            $feeStructure->school_id = $schoolId;
            $feeStructure->class_id = $classId;
            $feeStructure->student_type = $studentType;
            $feeStructure->term = $term;
            $feeStructure->fee_category_id = $feeCategoryIds[$i];
            $feeStructure->amount = $amounts[$i];
            $feeStructure->priority = $priorities[$i];
            $feeStructure->save();

            $insertedRecords[] = $feeCategoryIds[$i];
        }

        $insertedCount = count($insertedRecords);
        $skippedCount = count($skippedRecords);

        if ($skippedCount > 0) {
            Toastr::warning("Fee Structure Created Successfully ($insertedCount inserted, $skippedCount skipped)");
        } else {
            Toastr::success('Fee Structure Created Successfully');
        }

        return redirect()->route('settings.fee_structure.index');
    }


  


    public function copyFeeStructure(Request $request)
    {
        $classId = $request->input('class_id');
        $term = $request->input('term');
        $studentType = $request->input('student_type');
        $copyToClassId = $request->input('copy_to_class');
        $copyTerm = $request->input('copy_term');
        $copyStudentType = $request->input('copy_student_type');
        
        if ($classId == $copyToClassId && $term == $copyTerm && $studentType == $copyStudentType) {
            return response()->json(['message' => 'Cannot copy to the same source', 'status' => 'error']);
        }
        
        $existingData = FeeStructure::where('class_id', $copyToClassId)
            ->where('term', $copyTerm)
            ->where('student_type', $copyStudentType)
            ->exists();
        
        if ($existingData) {
            // Destination already has data
            return response()->json(['message' => 'Destination already has fee structure data', 'status' => 'error']);
        }
        



        if ($studentType != 'r' && $studentType != 't') {
            $studentTypeData = StudentType::where('school_id', auth()->user()->school_id)
                ->where('name', $studentType)
                ->first();
            
            if ($studentTypeData) {
                $studentType = $studentTypeData->id;
            }
        }
        
        // Copy the fee structure data to the new class, term, and student type
        $feeStructure = FeeStructure::where('class_id', $classId)
            ->where('term', $term)
            ->where('student_type', $studentType)
            ->get(); 
       
    
        // Iterate through the fee structure data and create new records for the copy
        foreach ($feeStructure as $fee) {
            $newFee = new FeeStructure();
            $newFee->school_id = auth()->user()->school_id;
            $newFee->class_id = $copyToClassId;
            $newFee->term = $copyTerm;
            $newFee->student_type = $copyStudentType;
            $newFee->fee_category_id = $fee->fee_category_id;
            $newFee->amount = $fee->amount;
            $newFee->priority = $fee->priority;
            $newFee->status = $fee->status;
            $newFee->save();
        }
    
        // Return a success response
        return response()->json(['message' => 'Fee Structure copied successfully']);
    }
    

    


}
