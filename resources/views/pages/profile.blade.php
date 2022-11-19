@extends('layouts.app')


@section('content')

  <div id="profile-container">
    <nav id="profile-options">
      <ul>
        <li>OVERVIEW</li>
        <li>POSTS</li>
        <li>COMMENTS</li>
        <li>LIKED</li>
        <li>DISLIKED</li>
        <li>FAVORITES</li>
      </ul>
    </nav>
    <div id="user-data">
      <p>User Data</p>
    </div>
    @include('partials.userinfo', ['user' => $user])
  </div>
@endsection