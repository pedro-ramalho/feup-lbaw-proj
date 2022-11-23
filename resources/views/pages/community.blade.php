@extends('layouts.app')
<?php
use App\Models\Community;
?>

@section('content')

  <div id="community-container">
    @include('partials.communityinfo', ['community' => $community])
    <div id="community-body">
      @include('partials.communitydata', ['community' => $community])
      <aside id="community-options">
          @include('partials.aboutcommunity', ['community' => $community])
          <a href="{{ route('submit_post', $community->id) }}">Create a post</a>
          @include('partials.communityrules', ['community' => $community])    
      </aside>
    </div>
  </div>

@endsection