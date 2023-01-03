<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function processCommentForm(Request $request, int $post_id) {
        // user is not authenticated, commenting on posts is not possible
        if (!Auth::user()) {
            abort(403);
        }

        $id_author = Auth::user()->id;
        $comment_text = $request->input('comment-text');
        
        // first, insert into the content table
        $id_content = DB::table('content')->insertGetId([
            'id_author' => $id_author,
            'is_post' => false,
        ]);
        
        // then, insert into the comment table
        DB::table('comment')->insert([
            'id' => $id_content,
            'id_parent' => $post_id,
            'text' => $comment_text
        ]);

        return redirect(route('post', $post_id));
    }

}
