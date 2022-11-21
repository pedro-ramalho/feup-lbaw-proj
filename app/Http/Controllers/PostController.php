<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\TextPost;
use App\Models\ImagePost;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        if ($post['is_image']) $model = ImagePost::find($id);
        else $model = TextPost::find($id);
        return view('pages.post', ['post' => $post])->withModel($model);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function getEditForm(int $id)
    {
        if (!Auth::check()) {
            echo 'User not authenticated!';
            abort(401);
        }
        else if (Auth::user()->content->contains(Content::find($id))) {
            $post = Post::find($id);
            if ($post['is_image']) $model = ImagePost::find($id);
            else $model = TextPost::find($id);    
            return view('pages.post_edit', ['post' => $post])->withModel($model);
        } else {
            echo "You don't have permission to edit this post!";
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function processEditForm(Request $request, int $id)
    {
        if (!Auth::check()) {
            echo 'User not authenticated!';
            abort(401);
        }
        else if (Auth::user()->content->contains(Content::find($id))) {
            $post = Post::find($id);
            $content = $post->content;

            if ($post->is_image) {
                $image_post = ImagePost::find($id);
                // TODO
            } else {
                $text_post = TextPost::find($id);
                $text_post->text = $request->input('new-post-text');
                $text_post->save();
            }

            $post->title = $request->input('new-post-title');
            $content->is_edited = true;
            $post->save();
            $content->save();
            
            return redirect(route('post', $id));
        } else {
            echo "You don't have permission to edit this post!";
            abort(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id) {
    if (!Auth::check()) {
        echo 'User not authenticated!';
        abort(401);
    }
    else if (Auth::user()->content->contains(Content::find($id))) {
        $post = Post::find($id);
        $community = $post->community;
        $content = $post->content;

        if ($post->is_image) {
            $image_post = ImagePost::find($id);
            // TODO
        } else {
            $text_post = TextPost::find($id);
            $text_post->text = "This post has been deleted.";
            $text_post->save();
        }

        $post->title = "[DELETED]";
        $content->is_deleted = true;
        $post->save();
        $content->save();
        
        return redirect(route('community', $community->name));
    } else {
        echo "You don't have permission to remove this post!";
        abort(403);
    }
}
}
