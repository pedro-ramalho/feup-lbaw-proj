@extends('layouts.app')

@section('content')
@include('layouts.sort')
@include('partials.popCommunities', ['communities' => $communities])

@endsection