@extends('layouts.app')

@section('content')
  <div id="delete-account" class="flex flex-col gap-y-4 p-4 items-center">
    <h1 class="text-2xl font-bold">Delete your account</h1>
    <form method="POST" action="{{ route('delete', $user->id) }}" class="flex flex-col gap-y-4">
      {{ csrf_field() }}
      <div class="flex items-center gap-x-2 text-xl">
        <i class="fa-solid fa-lock"></i>
        <label for="password" >Password</label>
      </div>
      <input class="p-1 border-b-2 text-base w-80 bg-white focus:bg-gray-100 focus:outline-none" id="password" type="password" name="password" required>
      <div class="flex items-center gap-x-2 text-xl">
        <i class="fa-solid fa-lock"></i>
        <label for="password" >Confirm Password</label>
      </div>
      <input class="p-1 border-b-2 text-base w-80 bg-white focus:bg-gray-100 focus:outline-none" id="confirm-password" type="password" name="confirm-password" required>
      <button type="submit" class="p-1 bg-red-500 border border-red-600 hover:bg-red-600 hover:cursor-pointer rounded-md w-full font-semibold text-white text-center">Confirm</button>
    </form>
  </div>
@endsection