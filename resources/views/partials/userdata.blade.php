<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

function get_rated_posts(int $id, bool $liked) {
  $rated = DB::table('users')
         ->join('content_rate', 'users.id', '=', 'content_rate.id_user')
         ->join('content', 'content.id', '=', 'content_rate.id_content')
         ->join('post', 'post.id', '=', 'content_rate.id_content')
         ->where('content_rate.id_user', '=', $id)
         ->where('content.is_post', '=', TRUE)
         ->where('content_rate.liked', '=', $liked)
         ->get();
  
  return $rated;
}

function get_rated_comments(int $id, bool $liked) {
  $rated = DB::table('users')
         ->join('content_rate', 'users.id', '=', 'content_rate.id_user')
         ->join('content', 'content.id', '=', 'content_rate.id_content')
         ->join('comment', 'comment.id', '=', 'content.id')
         ->where('content_rate.id_user', '=', $id)
         ->where('content.is_post', '=', FALSE)
         ->where('content_rate.liked', '=', $liked)
         ->get();
  
  return $rated;
}

function get_favorite_posts(int $id) {
  $fav_posts = DB::table('post')
               ->join('favorite_post', 'post.id', '=', 'favorite_post.id_post')
               ->where('favorite_post.id_user', '=', $id)
               ->get();
  
  return $fav_posts;
}
?>

<div id="user-data" class="mt-8 w-px-896 max-w-4xl flex flex-col gap-y-2">
  @include('layouts.sort')

  <div id="profile-posts" class="flex flex-col w-px-896 max-w-4xl gap-y-2">
    @each('partials.preview_post', $user->content()->where('is_post', TRUE)->join('post', 'content.id', '=', 'post.id')->get(), 'post')
  </div>
  <div id="profile-comments" class="flex flex-col w-px-896 max-w-4xl gap-y-2">
    @each('partials.preview_comment', $user->content()->where('is_post', FALSE)->join('comment', 'content.id', '=', 'comment.id')->get(), 'comment')
  </div>

  <div id="liked-content" class="flex flex-col w-px-896 max-w-4xl gap-y-2">
    @if (!get_rated_posts($user->id, TRUE)->isEmpty())
      @each('partials.preview_post', get_rated_posts($user->id, TRUE), 'post')
    @endif

    @if (!get_rated_comments($user->id, TRUE)->isEmpty())
      @each('partials.preview_comment', get_rated_comments($user->id, TRUE), 'comment')
    @endif
  </div>

  <div id="disliked-content" class="flex flex-col w-px-896 max-w-4xl gap-y-2">
    @if (!get_rated_posts($user->id, FALSE)->isEmpty())
      @each('partials.preview_post', get_rated_posts($user->id, FALSE), 'post')
    @endif

    @if (!get_rated_comments($user->id, FALSE)->isEmpty())
      @each('partials.preview_comment', get_rated_comments($user->id, FALSE), 'comment')
    @endif
  </div>

  <div id="favorited-content" class="flex flex-col w-px-896 max-w-4xl gap-y-2">
    @if (!get_favorite_posts($user->id)->isEmpty())
      @each('partials.preview_post', get_favorite_posts($user->id), 'post')
    @endif
  </div>
</div>
