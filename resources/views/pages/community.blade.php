@extends('layouts.app')


@section('content')

  <div id="community-container">
    <nav id="community-options">
      <ul>
        <li>Posts</li>
        <li>About</li>
        <li>Rules</li>
      </ul>
    </nav>
    <div id="community-data">
      <p>Community Data</p>
    </div>
    @include('partials.communityinfo', ['community' => $community])
  </div>

@endsection