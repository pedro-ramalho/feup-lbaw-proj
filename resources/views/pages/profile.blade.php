@extends('layouts.app')


@section('content')

  <div id="profile-container">
    <nav id="profile-options">
      <ul>
        <li>Overview</li>
        <li>Posts</li>
        <li>Comments</li>
        <li>Liked</li>
        <li>Disliked</li>
        <li>Favorites</li>
      </ul>
    </nav>
    <div id="user-data">
      <p>User Data</p>
    </div>
    @include('partials.userinfo', ['user' => $user])
  </div>

@endsection