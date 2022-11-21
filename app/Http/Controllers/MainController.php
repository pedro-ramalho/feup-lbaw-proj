<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Community;
use App\Models\User;
use App\Models\Content;
use App\Models\Post;
use App\Models\UserFollowCommunity;




class MainController extends Controller
{
    public function show() {
        
        $posts=collect();
        $userFollowCommunities=[];
        if (Auth::check()){
            
            $posts = Post::whereExists((function ($query) {
               $query->select(DB::raw(1))
                     ->from('user_follow_community')
                     ->whereColumn('user_follow_community.id_followee', 'post.id_community')
                     ->where('user_follow_community.id_follower', Auth::id());
           }))
           ->get();
           $userFollowCommunities = Auth::user()->follows()->get();
          
        }

        $ilikes=Post::find(2);
    
        if (!is_null($ilikes)){
        $likes= $ilikes->content()->find(2)->liked()->where('liked', True)->count();
        }
        else{
        $likes=[];
        }
        $allposts = Post::all()->take(10);
        $allposts->each(function($allpost,$key) use ($posts){
            if ($posts->doesntContain($allpost)){
                $ilikes=Post::find($allpost['id']);
                if (!is_null($ilikes)){
                    $likes= $ilikes->content()->find($allpost['id'])->liked()->where('liked', True)->count();
                    $allpost['likes']= $likes;                
                    
                }
             $posts->push(($allpost));
            }
        }); 
            $posts=$posts->sortByDesc('likes');

        $communities = Community::all()->take(5);

    
        return view('pages.main', ['communities' => $communities, 'posts' => $posts, 'userFollowCommunities' => $userFollowCommunities]);
    }

    public function showHot() {
        
        $posts=collect();
        $userFollowCommunities=[];
        if (Auth::check()){
            
            $posts = Post::whereExists((function ($query) {
               $query->select(DB::raw(1))
                     ->from('user_follow_community')
                     ->whereColumn('user_follow_community.id_followee', 'post.id_community')
                     ->where('user_follow_community.id_follower', Auth::id());
           }))
           ->get();
           $userFollowCommunities = Auth::user()->follows()->get();

        }
        
        $allposts = Post::all()->take(10);
        $allposts->each(function($allpost,$key) use ($posts){
            if ($posts->doesntContain($allpost)){
            $posts->push(($allpost));
            }
        });


        $communities = Community::all()->take(5);
    
        return view('pages.main', ['communities' => $communities, 'posts' => $posts, 'userFollowCommunities' => $userFollowCommunities]);
    }



}
