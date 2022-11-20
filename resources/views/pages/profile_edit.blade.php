@extends('layouts.app')

@section('content')
  @include('partials.useredit', ['user' => $user])
@endsection
