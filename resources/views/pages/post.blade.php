@extends('layouts.app')

<?php
use App\Models\Content;
function date_string($date_string)
{
  $date_created = date_create_from_format("Y-m-d H:i:s", $date_string);
  $now = new DateTime("now");
  $diff = $now->diff($date_created);
  if ($diff->y === 1) {
    return "1 year ago";
  } else if ($diff->y > 1) {
    return $diff->y . " years ago";
  } else if ($diff->m === 1) {
    return "1 month ago";
  } else if ($diff->m > 1) {
    return $diff->m . " months ago";
  } else if ($diff->d === 1) {
    return "1 day ago";
  } else if ($diff->d > 1) {
    return $diff->d . " days ago";
  } else if ($diff->h === 1) {
    return "1 hour ago";
  } else if ($diff->h > 1) {
    return $diff->h . " hours ago";
  } else if ($diff->d === 1) {
    return "1 minute ago";
  } else if ($diff->i > 1) {
    return $diff->i . " minutes ago";
  } else if ($diff->s === 1) {
    return "1 second ago";
  } else if ($diff->s > 1) {
    return $diff->s . " seconds ago";
  } else if ($diff->s == 0) {
    return "0 seconds ago";
  } else {
    return "error while reading dates";
  }
}
?>

@section('content')
<section id="content">
  <main>
    <div id="main-post">
      @if ($post->content->is_deleted)
      <p id="posted-by">Posted by <a href="#">u/deleted</a> on <a href="{{ route('community', $post->community->id) }}">c/{{ $post->community['name'] }}</a> <?php echo date_string(substr($post->content['created'], 0, 19));?></p>
      @else
        @auth
        @if (Auth::user()->content->contains(Content::find($post->id)))
        <form id ="delete-post-form" action="{{ route('delete_post', $post->id) }}" method="post" >
          <button id="delete-post-button" type="submit"><i class="fa-solid fa-trash"></i></button>
          @method('delete')
          @csrf
        </form>
        <a id="edit-post-button" href="{{ route('edit_post', $post->id) }}"><i class="fa-solid fa-pen"></i></a>  
        @endif
        @endauth
      <p id="posted-by">Posted by <a href="{{ route('user', $post->content->owner->id)}}">u/{{ $post->content->owner['username'] }}</a> on <a href="{{ route('community', $post->community->id) }}">c/{{ $post->community['name'] }}</a> <?php echo date_string(substr($post->content['created'], 0, 19));?></p>
      @endif
      <h1 id="post-title">
        {{$post['title']}}
      </h1>
      <p id="tag">{{ $post->tag['name'] }}</p>
      @if ($post['is_image'])
      <img src="" alt="post image" id="post-image">
      @else
      <p id="post-text"> {{ $model->find($post['id'])['text']}}</p>
      @endif
      <section id="post-interactables">
      <div class="preview-post-rating flex gap-x-4">
      <div id="preview-post-like" class="flex gap-x-2 items-center">
        @auth
          @if ($post->content->likers->contains(Auth::user()))
            <button id="like-post{{$post->id}}" data-id="{{$post->id}} " class="like-post-button" type="submit" data-likepressed="1">
              <i id="like-post{{$post->id}}-symb" class="fa-solid fa-thumbs-up text-black text-3xl"></i>
            </button>
          @else
            <button id="like-post{{$post->id}}" data-id="{{$post->id}}" class="like-post-button" type="submit" data-likepressed="0">
              <i id="like-post{{$post->id}}-symb" class="fa-solid fa-thumbs-up text-gray-500 text-3xl"></i>
            </button>
          @endif
        @endauth
        @guest
          <i class="fa-solid fa-thumbs-up text-gray-500 text-3xl"></i>
        @endguest
        <p class="font-normal" id="post{{$post->id}}likes"> <span>{{ $post->likes }}</span></p>
      </div>
      <div id="preview-post-dislike" class="flex gap-x-2 items-center">
        @auth
          @if ($post->content->dislikers->contains(Auth::user()))
            <button id="dislike-post{{$post->id}}" data-id="{{$post->id}} " class="dislike-post-button" type="submit" data-dislikepressed="1">
              <i id="dislike-post{{$post->id}}-symb" class="fa-solid fa-thumbs-down text-black text-3xl"></i>
            </button>
        @else
            <button id="dislike-post{{$post->id}}" data-id="{{$post->id}}" class="dislike-post-button" type="submit" data-dislikepressed="0">
              <i id="dislike-post{{$post->id}}-symb" class="fa-solid fa-thumbs-down text-gray-500 text-3xl"></i>
            </button>
        @endif
        @endauth
        @guest
          <i class="fa-solid fa-thumbs-down text-gray-500 text-3xl"></i>
        @endguest
        <p class="font-normal" id="post{{$post->id}}dislikes"> <span>{{$post->dislikes}}</span></p>
      </div>
    </div>
        <div class="comments"><i class="fa-solid fa-comment"></i> <span class="interactable-text">{{ $post->content->comments->count() }} comments</span></div>
        <div class="favorite"><i class="fa-regular fa-star"></i> <span class="interactable-text">Add to favorites</span></div>
        <div class="report"><i class="fa-solid fa-flag"></i> <span class="interactable-text">Report post</span></div>
      </section>
      <form action="">
        <textarea name="comment-text" id="post-comment-text" placeholder="Write your comment..."></textarea>
        <button type="submit">Comment</button>
      </form>
    </div>
    <div id="comments">
      @foreach ($post->content->comments as $comment)
      @include('partials.comment', ['comment' => $comment])
      @endforeach
    </div>
  </main>
  <aside>
    @include('partials.aboutcommunity', ['community' => $post->community])
    @include('partials.communityrules', ['community' => $post->community])
  </aside>
</section>
@endsection