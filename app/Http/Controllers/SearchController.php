<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class SearchController extends Controller
{
    /**
     * Display the search results for the specified string.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $fulltext_string = $request->query('q');

        $exact_posts = Post::all()->where('title', '=', $fulltext_string);
        $fulltext_posts = Post::whereRaw("tsvectors @@ plainto_tsquery('english', ?)", [$fulltext_string])->get();
        $unique_ft_posts = [];
        foreach ($fulltext_posts as $post_row) {
            $post = Post::find($post_row['id']);
            if (!$exact_posts->contains($post)) {
                $unique_ft_posts[] = $post;
            }
        }
        
        $users = User::whereRaw("tsvectors @@ plainto_tsquery('english', ?)", [$fulltext_string])->get(); 
        return view('pages.search', ['exact_posts' => $exact_posts, 'fulltext_posts' => $unique_ft_posts, 'users' => $users]);
    }
}
