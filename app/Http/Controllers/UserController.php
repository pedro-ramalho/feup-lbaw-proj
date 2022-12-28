<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function show($id) {
        $user = User::find($id);
        $this->authorize('show', $user);

        return view('pages.profile', ['user' => $user]);
    }

    public function getEditForm(int $id) {
        if (!Auth::check()) {
            abort(401);
        }

        if (Auth::user()->id !== $id) {
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

    public function follow_community(int $id) {
        if (Auth::check()) {
            DB::table('user_follow_community')->insert([
                'id_follower' => Auth::id(),
                'id_followee' => $id
            ]);
        return redirect(route('community', $id));
        } else {
            return redirect(route('login'));
        }
    }
    
    public function unfollow_community(int $id) {
        if (Auth::check()) {
            DB::table('user_follow_community')->where('id_followee', $id)->where('id_follower', Auth::id())->delete();
            return redirect(route('community', $id));
        } else {
            return redirect(route('login'));
        }
    }

    public function reports() {
        return $this->hasMany(ReportInformation::class, 'id_content');
    }


}