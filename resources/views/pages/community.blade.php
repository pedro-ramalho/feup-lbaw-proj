@extends('layouts.app')


@section('content')

  <div id="community-container">
    @include('partials.communityinfo', ['community' => $community])
    <nav id="community-options">
      <ul>
        <li>About</li>
        <li>Rules</li>
      </ul>
    </nav>
    <div id="community-data">
      @include('partials.communitydata', ['community' => $community])
    </div>
  </div>

@endsection