<?php

namespace App\Http\Controllers;

use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class SignupController extends Controller
{
    public function index()
    {
        return view('signup.index');
    }
   
    public function store(Request $request)
    {

        $request->validate([
            'school_name' => 'required|string|max:255',
            'school_username' => 'required|string|max:255|unique:schools,username',
            'school_address' => 'required|string|max:255',
            'school_phone' => 'required|string|max:255',
            'school_email' => 'nullable|email|max:255',
            'school_website' => 'nullable|string|max:255',
            
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:255|unique:users,phone',
            'password' => 'required|string|min:8',
            'agree_terms' => 'required|accepted',
            'decision_on_behalf' => 'required|accepted',
        ]);

        $admin = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'usertype' => 'admin',
            'school_id' => 1, // We'll assign the school_id later
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => Hash::make($request->input('password')),
        ]);

        $school = School::create([
            'name' => $request->input('school_name'),
            'username' => $request->input('school_username'),
            'address' => $request->input('school_address'),
            'phone_first' => $request->input('school_phone'),
            'email' => $request->input('school_email'),
            'website' => $request->input('school_website'),
            'admin_id' => $admin->id, 
        ]);

        

        $admin->update(['school_id' => $school->id]);

        Auth::login($admin);


        return response()->json(['message' => 'Registration successful'], 201);

    }





}
