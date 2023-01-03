<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportPostController extends Controller
{
    public function show()
    {
        return view('pages.report_post');
    }
}