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
        $allposts=$posts;
        $posts=collect();   
        $newposts = Post::all()->random(10);
        $newposts->each(function($newpost,$key) use ($allposts){
            $allposts->push($newpost);
        });
        $allposts=$allposts->unique();
        
        $allposts->each(function($allpost,$key) use ($posts){
                $ilikes=Post::find($allpost['id']);
                if (!is_null($ilikes)){
                    $likes= $ilikes->content()->find($allpost['id'])->liked()->where('liked', True)->count();
                    $dislikes= $ilikes->content()->find($allpost['id'])->liked()->where('liked', False)->count();
                    $allpost['likes']= $likes;   
                    $allpost['dislikes']= $dislikes;           
                }
                $posts->push(($allpost));
        }); 
        $posts=$posts->take(10);


        $communities = Community::all()->random(5);

    
        return view('pages.main', ['communities' => $communities, 'posts' => $posts, 'userFollowCommunities' => $userFollowCommunities]);
    }

    
    public function showTop() {
        
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
        $allposts=$posts;
        $posts=collect();   
        $newposts = Post::all();
        $newposts->each(function($newpost,$key) use ($allposts){
            $allposts->push($newpost);
        });
        $allposts=$allposts->unique();
        
        $allposts->each(function($allpost,$key) use ($posts){
                $ilikes=Post::find($allpost['id']);
                if (!is_null($ilikes)){
                    $likes= $ilikes->content()->find($allpost['id'])->liked()->where('liked', True)->count();
                    $dislikes= $ilikes->content()->find($allpost['id'])->liked()->where('liked', False)->count();
                    $allpost['likes']= $likes;   
                    $allpost['dislikes']= $dislikes;
                }
                $posts->push(($allpost));
            }); 
            
            $posts=$posts->sortBy([['likes', 'desc'], ['dislikes', 'asc']]);
            $posts=$posts->take(10);
            
            $communities = Community::all()->random(5);
            
            
            return view('pages.main', ['communities' => $communities, 'posts' => $posts, 'userFollowCommunities' => $userFollowCommunities]);
        }
        
        
        public function showNew() {
            
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
        $allposts=$posts;
        $posts=collect();   
        $newposts = Post::all();
        $newposts->each(function($newpost,$key) use ($allposts){
            $allposts->push($newpost);
        });
        $allposts=$allposts->unique();
        
        $allposts->each(function($allpost,$key) use ($posts){
            $ilikes=Post::find($allpost['id']);
            if (!is_null($ilikes)){
                $likes= $ilikes->content()->find($allpost['id'])->liked()->where('liked', True)->count();
                $dislikes= $ilikes->content()->find($allpost['id'])->liked()->where('liked', False)->count();
                $created= $ilikes->content()->find($allpost['id']);               
                $allpost['likes']= $likes;   
                $allpost['dislikes']= $dislikes;               
                $allpost['created']= $created->created;   
            }
            $posts->push(($allpost));
        }); 
        $posts=$posts->sortByDesc('created');
        $posts=$posts->take(10);
        
    $communities = Community::all()->random(5);
    
    
    return view('pages.main', ['communities' => $communities, 'posts' => $posts, 'userFollowCommunities' => $userFollowCommunities]);
}






    //}
}
