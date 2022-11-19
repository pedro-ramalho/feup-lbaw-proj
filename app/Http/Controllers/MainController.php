<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Community;


class MainController extends Controller
{
    public function show() {

        $communities = array($community = Community::find(1),$community = Community::find(2),$community = Community::find(3));
         
        return view('pages.main', ['communities' => $communities]);
    }

    



}
