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
        if (Auth::user()->id !== $id) {
            abort(403);
        }
        
        return view('pages.profile_edit', ['user' => Auth::user()]);
    }

    public function getDeleteForm(int $id) {
        if (Auth::user()->id !== $id) {
            abort(403);
        }

        return view('pages.profile_delete', ['user' => Auth::user()]);
    }

    public function getNotifications(int $id) {
        if (Auth::user()->id !== $id) {
            abort(403);
        }

        return view('pages.notifications', ['user' => Auth::user()]);
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

    public function processDeleteForm(Request $request, int $id) {
        if (Auth::user()->id !== $id) {
            abort(403);
        }

        $pw = $request->input('password');
        $cpw = $request->input('confirm-password');

        // password field and confirm password field did not match
        if ($pw !== $cpw) {
            abort(403);
        }

        $user = User::findOrFail($id);

        $user->is_deleted = TRUE;

        $user->save();

        return redirect(route('logout'));
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

    public function deleteLikeNotification(int $id){
    
        DB::table('like_notification')->where('id', '=', $id)->delete();
    
    }

    public function deleteFollowNotification(int $id){

        DB::table('follow_notification')->where('id', '=', $id)->delete();
    }
    
    public function deleteReplyNotification(int $id){
    
       
       DB::table('reply_notification')->where('id', '=', $id)->delete();

    }
}