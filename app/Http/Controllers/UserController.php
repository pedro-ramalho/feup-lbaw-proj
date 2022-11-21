<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function show($id) {
        $user = User::find($id);
        $this->authorize('show', $user);

        return view('pages.profile', ['user' => $user]);
    }

    public function getEditForm() {
        if (!Auth::check()) {
            echo 'User not authenticated'; // for debug purposes only
            abort(403);
        }
        
        return view('pages.profile_edit', ['user' => Auth::user()]);
    }

    public function processEditForm(Request $request, int $id) {
        if (Auth::user()->id !== $id) {
            echo 'UNAUTHORIZED ACTION';
            abort(403);
        }

        $user = User::findOrFail($id);

        $user->biography = $request->input('biography');

        $user->save();

        return redirect(route('user', $id));
    }

    public function delete(Request $request) {
       $user = User::where('username', $request->input('username'))->first();
        
       var_dump($user);

       $user->is_deleted = true;

       $user->save();

       return redirect(route('admin'));
    }
}