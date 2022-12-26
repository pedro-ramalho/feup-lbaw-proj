@extends('layouts.app')

@section('content')
<section id="signup" class="mt-4 flex flex-col items-center gap-y-4">
<h1 class="text-3xl ">Sign up to Rabbit</h1>
<form method="POST" action="{{ route('register') }}" class="auth-form flex flex-col gap-y-2 p-2 text-xl">
    {{ csrf_field() }}

    <div class="flex items-center gap-x-2">
      <i class="fa-sharp fa-solid fa-user"></i>
      <label for="usrname">Username</label>
    </div>
    <input class="p-1 border-b-2 text-base w-80 bg-white focus:bg-gray-100 focus:outline-none" id="usrname" type="text" name="username" value="{{ old('username') }}" required autofocus>
    @if ($errors->has('username'))
      <span class="error">
          {{ $errors->first('username') }}
      </span>
    @endif

    <div class="flex items-center gap-x-2">
        <i class="fa-solid fa-envelope"></i>
        <label for="email" class="">E-mail</label>
    </div>
    <input class="p-1 border-b-2 text-base w-80 bg-white focus:bg-gray-100 focus:outline-none" id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
    @if ($errors->has('email'))
        <span class="error">
          {{ $errors->first('email') }}
        </span>
    @endif

    <div class="flex items-center gap-x-2">
        <i class="fa-solid fa-lock"></i>
        <label for="password" >Password</label>
    </div>
    <input class="p-1 border-b-2 text-base w-80 bg-white focus:bg-gray-100 focus:outline-none" id="password" type="password" name="password" required>
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif

    <div class="flex items-center gap-x-2">
        <i class="fa-solid fa-lock"></i>
        <label for="password" >Confirm Password</label>
    </div>
    <input class="p-1 border-b-2 text-base w-80 bg-white focus:bg-gray-100 focus:outline-none" id="password" type="password" name="password" required>
    @if ($errors->has('password'))
        <span class="error">
            {{ $errors->first('password') }}
        </span>
    @endif

    <div id="signin-signup-container" class="flex flex-col items-center gap-y-2 mt-2">
        <button type="submit" class="p-1 bg-green-500 border border-green-600 hover:bg-green-600 hover:cursor-pointer rounded-md w-full font-semibold text-white">Sign up</button>
        <a class="button button-outline p-1 text-base text-center w-full" href="{{ route('login') }}">Already have an account? <span class="text-sky-600">Sign in instead.</span></a>
    </div>
</form>
</section>
@endsection
