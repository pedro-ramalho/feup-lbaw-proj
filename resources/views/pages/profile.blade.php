@extends('layouts.app')


@section('content')

  <div id="profile-container">
    <nav id="profile-options" class="bg-gray-900 p-2 text-white">
      <ul class="flex justify-center p-2 gap-x-16 text-xl list-none list-inside">
        <li class="font-semibold" id="opt-overview">OVERVIEW</li>
        <li class="font-semibold" id="opt-posts">POSTS</li>
        <li class="font-semibold" id="opt-comments">COMMENTS</li>
        <li class="font-semibold" id="opt-liked">LIKED</li>
        <li class="font-semibold" id="opt-disliked">DISLIKED</li>
        <li class="font-semibold" id="opt-favorites">FAVORITES</li>
      </ul>
    </nav>
  
    @include('partials.userdata', ['user' => $user])
    @include('partials.userinfo', ['user' => $user])
  </div>
@endsection