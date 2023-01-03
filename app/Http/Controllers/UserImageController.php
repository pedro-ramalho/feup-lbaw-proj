<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class UserImageController extends Controller
{
    public function update(Request $request) {
        $id = Auth::user()->id;

        $path = $request->file('pfp')->storeAs(
            'users', $request->user()->$id
        );
        Storage::disk('public')->put(Auth::user()->id . '.png', $request->file('pfp')); 


        return $path;
    }

}
