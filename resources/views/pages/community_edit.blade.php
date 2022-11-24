@extends('layouts.app')


@section('content')
    <form action="{{ route('edit_community', $community->id) }}" method="post" id="edit-community">
        {{ csrf_field() }}
        <p id="header">Edit community:</p>
        <p id="name">Name</p>
        <input type="text" name="new-community-name" id="new-community-name" value="{{$community['name']}}" required>
        <p id="description">Description</p>
        <input type="text" name="new-community-description" id="new-community-description" value="{{$community['description']}}" required>
        <button type="submit">Save</button>
    </form>
@endsection
