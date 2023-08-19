<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\Subscription;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class AccountInformationController extends Controller
{
    public function index()
    {
        $school = School::select('id','session_id','term')->where('id',auth()->user()->school_id)->first();

        $subscriptions = $school->subscriptions();

        if ($subscriptions->count() === 0) {
            Toastr::error('Create a session and Set your current Session/Term to start your Free Trial');
            return redirect()->route('settings.basic.index');
        } 


        return view('account_information.index', compact('school'));
    }
}
