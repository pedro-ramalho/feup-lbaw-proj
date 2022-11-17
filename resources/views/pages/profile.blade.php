@extends('layouts.app')


@section('content')
  @include('partials.userinfo', ['user' => $user])
@endsection