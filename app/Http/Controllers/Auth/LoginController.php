<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/user/2';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getUser(){
        return $request->user();
    }

    public function home() {
        return redirect('user/{id}');
    }

    public function logout(Request $request) {
        Auth::logout();
        
        return redirect('login');
    }

    public function redirectTo() {
        $id = Auth::user()->id;

        $user = User::find($id);
        
        $redirect = $user->is_admin ? 'admin' 
                                    : 'main';
        

        if ($user->is_admin) {
            $redirect = 'admin';
        }
        if ($user->is_deleted) {
            $redirect = 'logout';
        }

        $redirect = 'main';
        
        return $redirect;
    }
}
