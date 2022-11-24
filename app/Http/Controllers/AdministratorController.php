<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



class AdministratorController extends Controller
{
    public function show() {
        if (!Auth::check()) {
            abort(401, "UNAUTHORIZED ACCESS");
        }
        
        $user = User::find(Auth::id());

        if (!$user->is_admin) {
            abort(403, "UNAUTHORIZED ACCESS");
        }
        
        return view('pages.admin');        
    }

    public function getCreateUser() {
        if (!Auth::check()) {
            abort(401, "UNAUTHORIZED ACCESS");
        }
        
        $user = User::find(Auth::id());

        if (!$user->is_admin) {
            abort(403, "UNAUTHORIZED ACCESS");
        }
        
        return view('pages.admin_create_user');
    }

    public function handleCreateUser(Request $request) {
        $user = User::create([
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
        ]);
        return redirect(route('user', $user->id));
    }
}
