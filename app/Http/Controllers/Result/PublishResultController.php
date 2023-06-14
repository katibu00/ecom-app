<?php

namespace App\Http\Controllers\Result;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PublishResultController extends Controller
{
    public function index()
    {
        return view('results.publish.index');
    }

}
