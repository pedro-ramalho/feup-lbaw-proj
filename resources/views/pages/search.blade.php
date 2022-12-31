@extends('layouts.app')

<?php
  use App\Models\Post;
?>

@section('content')
<section id="search-section" class="flex flex-col items-center">
  <nav id="profile-options" class="bg-gray-900 text-white w-full">
    <ul class="flex justify-center p-4 gap-x-16 text-xl list-none list-inside">
      <li class="font-bold hover:cursor-pointer" id="opt-search-posts">POSTS</li>
      <li class="hover:cursor-pointer" id="opt-search-users">USERS</li>
    </ul>
  </nav>
  <div id="display-results" class="flex flex-col items-center mt-4">
    <div id="post-results" class="flex flex-col items-center gap-y-2">
      @if (count($exact_posts) != 0 || count($fulltext_posts) != 0)
        @foreach ($exact_posts as $post)
          <article class="post-preview">
            @include('partials.preview_post', ['post' => $post])
          </article>
        @endforeach

        @foreach ($fulltext_posts as $post)
          <article class="post-preview">
            @include('partials.preview_post', ['post' => $post])
          </article>
        @endforeach
      @else
        <p class="italic text-gray-400 text-center">No matches were found.</p>
      @endif

    </div>

    <div id="user-results" class="hidden flex-col items-center gap-y-2 w-px-896 max-w-4xl">
      @if (count($users) == 0)
        <p class="italic text-gray-400 text-center">No matches were found.</p>
      @else
        @each ('partials.preview_user', $users, 'user')
      @endif
    </div>
  </div>
      
</section>
@endsection