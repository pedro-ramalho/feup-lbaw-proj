@extends('layouts.app')

@section('content')
<nav id= main-content>
  @include('layouts.sort')
  @include('partials.popCommunities', ['communities' => $communities, 'userFollowCommunities' => $userFollowCommunities])
  <nav id= main-posts>
    @each('partials.preview_post', $posts, 'post')
  </nav>
</nav>
@endsection