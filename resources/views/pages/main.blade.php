@extends('layouts.app')

@section('content')
<nav id= mainContent>
@include('layouts.sort')
@include('partials.popCommunities', ['communities' => $communities])
<nav id= mainPosts>
@each('partials.preview_post', $posts, 'post')
</nav>
@include('partials.topics')
</nav>
@endsection