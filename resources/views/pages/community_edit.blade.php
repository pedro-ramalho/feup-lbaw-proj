@extends('layouts.app')

<form action="{{ route('edit_community', $community->id) }}" method="post" id="edit_community">
    {{ csrf_field() }}
    <input type="text" name="new-community-name" id="new-community-name" value="{{$community['name']}}" required>
    <input type="text" name="new-community-description" id="new-community-description" value="{{$community['description']}}" required>
    <button type="submit">Save</button>
</form>