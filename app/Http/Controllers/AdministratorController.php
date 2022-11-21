<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AdministratorController extends Controller
{
    public function show() {
        if (!Auth::check()) {
            abort(403, "UNAUTHORIZED ACCESS");
        }
        
        
        return view('pages.admin');        
    }
}
