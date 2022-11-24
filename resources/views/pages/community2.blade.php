@extends('layouts.app')

<?php use App\Models\Community;?>

@section('content')
@include('partials.communityinfo', ['community' => $community])
<section id="content-c2">
  <main>
    @include ('layouts.sort')
    <div id="main-posts">
      @each('partials.preview_post', $community->posts()->get(), 'post')
    </div>
  </main>
  <aside>
    @include('partials.aboutcommunity', ['community' => $community])
    @auth
      @if (Auth::user()->community->contains(Community::find($community->id)))
        <a id="edit-community-button" href="{{ route('edit_community', $community->id) }}">Edit community</a>
      @endif
    @endauth
    <a href="{{ route('submit_post', $community->id) }}">Create a post</a>
    @include('partials.communityrules', ['community' => $community])
  </aside>
</section>
@endsection