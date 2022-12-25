<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\TextPost;
use App\Models\ImagePost;
use App\Models\Content;
use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function create($id)
    {
        $community = Community::find($id);
        return view('pages.post_submit', ['community' => $community]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        if (!Auth::check()) {
            echo 'User not authenticated!';
            abort(401);
        }
        else {
            $content = Content::create([
                'id_author' => Auth::id(),
                'is_post' => true
            ]);

            $post = Post::insert([
                'id' => $content->id,
                'id_community' => $request->input('community-id'),
                'id_tag' => 11,
                'title' => $request->input('title'),
                'is_image' => false
            ]);
            if ($request->input('is_image') == 1) {
                $image_post = ImagePost::create([
                    'id' => $post->id,
                    'id_image' => $request->input('id-image')
                ]); 
            } else {
                $text_post = TextPost::insert([
                    'id' => $content->id,
                    'text' => $request->input('text')
                ]);
            }
            return redirect(route('post', $content->id));
        }
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
        echo "OOOOOOOOOOOOHH MY GAWD";
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
        
        #return redirect(route('community', $community->name));
        return redirect(route('post', $post->id));
    } else {
        echo "You don't have permission to remove this post!";
        abort(403);
    }
    }
    public function likePost(int $id){
        if (Auth::check()) {
        DB::table('content_rate')->where('id_content', $id)->where('id_user', Auth::id())->where('liked', FALSE)->delete();
        DB::table('content_rate')->insert([
                'id_content'=> $id,
                'id_user'=> Auth::id(),
                'liked'=> TRUE
            ]);
        }
        return redirect(route('main'));
    }
    public function removeLikePost(int $id){
        if (Auth::check()){
            DB::table('content_rate')->where('id_content', $id)->where('id_user', Auth::id())->where('liked', TRUE)->delete();
        }
        return redirect(route('main'));
    }
    public function dislikePost(int $id){
        if (Auth::check()) {
        DB::table('content_rate')->where('id_content', $id)->where('id_user', Auth::id())->where('liked', TRUE)->delete();
        DB::table('content_rate')->insert([
                'id_content'=> $id,
                'id_user'=> Auth::id(),
                'liked'=> FALSE
            ]);
        }
        return redirect(route('main'));
    }
    public function removeDislikePost(int $id){
        if (Auth::check()){
            DB::table('content_rate')->where('id_content', $id)->where('id_user', Auth::id())->where('liked', FALSE)->delete();
        }
        return redirect(route('main'));
    }
}
