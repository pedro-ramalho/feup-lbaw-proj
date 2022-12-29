@extends('layouts.app')

<?php
  use App\Models\Post;
?>

@section('content')
<section id="search-section" class="flex flex-col items-center">
  <nav id="profile-options" class="bg-gray-900 text-white w-full">
    <ul class="flex justify-center p-4 gap-x-16 text-xl list-none list-inside">
      <li class="font-bold hover:cursor-pointer" id="opt-overview">POSTS</li>
      <li class="hover:cursor-pointer" id="opt-comments">USERS</li>
    </ul>
  </nav>
  <div id="display-results" class="flex flex-col items-center">
    <div id="post-results">
      @if (count($exact_posts) == 0)
        <p>No matches were found</p>
      @else
        @foreach ($exact_posts as $post)
          <article class="post-preview">
            @include('partials.preview_post', ['post' => $post])
          </article>
        @endforeach
      @endif

      @if (count($exact_posts) == 0)
        <p>No matches were found</p>
      @else
        @foreach ($exact_posts as $post)
          <article class="post-preview">
            @include('partials.preview_post', ['post' => $post])
          </article>
        @endforeach
      @endif

      @if (count($fulltext_posts) == 0)
          <p>No matches were found</p>
        @else
          @foreach ($fulltext_posts as $post)
            <article class="post-preview">
              @include('partials.preview_post', ['post' => $post])
            </article>
          @endforeach
      @endif
    </div>

    <div id="user-results">
      @if (count($users) == 0)
        <p>No matches were found</p>
      @else
        @each ('partials.preview_user', $users, 'user')
      @endif
    </div>
  </div>
      
</section>
@endsection