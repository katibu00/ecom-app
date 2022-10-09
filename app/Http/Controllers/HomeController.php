<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function intellisas()
    {
        return view('home.intellisas');
    }
    public function admin()
    {
        return view('home.admin');
    }
}
