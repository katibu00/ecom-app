<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class StudentDocumentsController extends Controller
{

    public function idCardIndex()
    {
        $user = auth()->user();

        if($user->usertype == 'teacher' || $user->usertype == 'accountant')
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('form_master_id',$user->id)->where('status',1)->get();
        }else
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('status',1)->get();
        }  
        return view('student_documents.idcards.index',$data);
    }
    
    public function answersheetIndex()
    {
        $user = auth()->user();

        if($user->usertype == 'teacher' || $user->usertype == 'accountant')
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('form_master_id',$user->id)->where('status',1)->get();
        }else
        {
            $data['classes'] = Classes::select('id','name')->where('school_id',$user->school_id)->where('status',1)->get();
        }  
        return view('student_documents.answersheets.index',$data);
    }

    public function generateIDCards(Request $request)
    {
        $classId = $request->input('class_id');

        $students = User::with('parent')->where('class_id', $classId)->get();
        $school = School::select('name','address','website','username')->where('id',auth()->user()->school_id)->first();

        // $pdf = PDF::loadView('pdfs.student_documents.idcard', ['students' => $students,'school'=>$school]);

        // $filename = 'id_cards_class_' . $classId . '.pdf';

        // // Return the PDF as a download response
        // return $pdf->download($filename);

        return view('pdfs.student_documents.idcard', ['students' => $students,'school'=>$school]);

    }
    
    public function generateAnswersheet(Request $request)
    {
        $classId = $request->input('class_id');

        $students = User::with('parent')->where('class_id', $classId)->get();
        $school = School::select('name','address','website','username','id','session_id','term','heading','logo')->where('id',auth()->user()->school_id)->first();

        // $pdf = PDF::loadView('pdfs.student_documents.idcard', ['students' => $students,'school'=>$school]);

        // $filename = 'id_cards_class_' . $classId . '.pdf';

        // // Return the PDF as a download response
        // return $pdf->download($filename);

        return view('pdfs.student_documents.answersheets', ['students' => $students,'school'=>$school]);

    }



}
