@extends('layouts.app')


@section('content')

  <div id="profile-container">
    <nav id="profile-options" class="bg-gray-900">
      <ul>
        <li id="opt-overview">OVERVIEW</li>
        <li id="opt-posts">POSTS</li>
        <li id="opt-comments">COMMENTS</li>
        <li id="opt-liked">LIKED</li>
        <li id="opt-disliked">DISLIKED</li>
        <li id="opt-favorites">FAVORITES</li>
      </ul>
    </nav>
  
    @include('partials.userdata', ['user' => $user])
    @include('partials.userinfo', ['user' => $user])
  </div>
@endsection