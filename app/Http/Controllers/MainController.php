<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Community;
use App\Models\Post;
use App\Models\UserFollowCommunity;




class MainController extends Controller
{
    public function show() {
        

        if (Auth::check()){
            
            $posts = Post::whereExists((function ($query) {
               $query->select(DB::raw(1))
                     ->from('user_follow_community')
                     ->whereColumn('user_follow_community.id_followee', 'post.id_community')
                     ->where('user_follow_community.id_follower', Auth::id());
           }))
           ->get();
          
        }
        else {
            $posts = array($post=Post::find(1),$post=Post::find(2),$post=Post::find(3),$post=Post::find(5));
        }
        
        $communities = Community::all()->take(5);
        $userFollowCommunities = Auth::user()->follows()->get();
    
        return view('pages.main', ['communities' => $communities, 'posts' => $posts, 'userFollowCommunities' => $userFollowCommunities]);
    }

    



}
