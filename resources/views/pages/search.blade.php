@extends('layouts.app')

<?php
  use App\Models\Post;
?>

@section('content')
<section id="search-section">
  <main>
    <h1>Exact post matches:</h1>
    <section class="pu-display-results">
      @if (count($exact_posts) == 0)
        <p>No matches were found</p>
      @else
        @foreach ($exact_posts as $post)
          <article class="post-preview">
            @include('partials.preview_post', ['post' => $post])
          </article>
        @endforeach
      @endif
      </section>
    <h1>Other post matches:</h1>
    <section class="pu-display-results">
        @if (count($fulltext_posts) == 0)
          <p>No matches were found</p>
        @else
          @foreach ($fulltext_posts as $post)
            <article class="post-preview">
              @include('partials.preview_post', ['post' => $post])
            </article>
          @endforeach
        @endif
    </section>
    <h1>User matches:</h1>
    <section class="pu-display-results">
        @if (count($users) == 0)
          <p>No matches were found</p>
        @else
          @each ('partials.preview_user', $users, 'user')
        @endif
    </section>
  </main>
</section>
@endsection