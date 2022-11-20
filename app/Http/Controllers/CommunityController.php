<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Community;
use App\Models\Post;

class CommunityController extends Controller
{
    public function show($id){
        $community = Community::find($id);
     
        return view('pages.community', ['community' => $community]);
    }
}