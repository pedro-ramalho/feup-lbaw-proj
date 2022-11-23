<?php

namespace App\Http\Controllers;

use App\Models\Community;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommunityController extends Controller
{
    public function show($id){
        $community = Community::find($id);
     
        return view('pages.community', ['community' => $community]);
    }

    public function getEditForm(int $id){
        if(!Auth::check()){
            echo 'User not authenticated!';
            abort(401);
        }
        else if(Auth::user()->community->contains(Community::find($id))){
            $community = Community::find($id);
            return view('pages.community_edit', ['community' => $community]);
        }
        else{
            echo "You don't have permission to edit this post!";
            abort(403);
        }
    }

    public function processEditForm(Request $request, int $id){
        if(!Auth::check()){
            echo 'User not authenticated!';
            abort(401);
        }
        else if(Auth::user()->community->contains(Community::find($id))){
            $community = Community::find($id);
            $community->name= $request->input('new-community-name');
            $community->description = $request->input('new-community-description');
            $community->save();
            return redirect(route('community', $id));
        }
        else{
            echo "You don't have permission to edit this post!";
            abort(403);
        }
    }


}