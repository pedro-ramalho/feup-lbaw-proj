@extends('layouts.app')


@section('content')

  <div id="profile-container">
    <nav id="profile-options" class="bg-gray-900 text-white">
      <ul class="flex justify-center p-4 gap-x-16 text-xl list-none list-inside">
        <li class="font-bold hover:cursor-pointer" id="opt-overview">OVERVIEW</li>
        <li class="hover:cursor-pointer" id="opt-posts">POSTS</li>
        <li class="hover:cursor-pointer" id="opt-comments">COMMENTS</li>
        <li class="hover:cursor-pointer" id="opt-liked">LIKED</li>
        <li class="hover:cursor-pointer" id="opt-disliked">DISLIKED</li>
        <li class="hover:cursor-pointer" id="opt-favorites">FAVORITES</li>
      </ul>
    </nav>
  
    @include('partials.userdata', ['user' => $user])
    @include('partials.userinfo', ['user' => $user])
  </div>
@endsection