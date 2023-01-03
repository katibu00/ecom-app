<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use App\Models\PaymentRecord;
use App\Models\School;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function index()
    {
        $school = School::select('id','session_id','term')->where('id',auth()->user()->school_id)->first();
        $data['payments'] = PaymentRecord::where('school_id', $school->id)->where('session_id',$school->session_id)->where('term',$school->term)->orderBy('created_at','desc')->get();
        return view('accounting.payments.index',$data);
    }
}
