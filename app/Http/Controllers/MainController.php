<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Community;
use App\Models\Post;


class MainController extends Controller
{
    public function show() {

        $communities = array($community = Community::find(1),$community = Community::find(2),$community = Community::find(3));
        $posts = array($post=Post::find(1),$post=Post::find(2),$post=Post::find(3),$post=Post::find(5));
        return view('pages.main', ['communities' => $communities], ['posts' => $posts]);
    }

    



}
