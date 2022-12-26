@extends('layouts.app')

@section('content')
<section id="signin" class="mt-4 flex flex-col items-center gap-y-4">
<h1 class="text-3xl ">Sign in to Rabbit</h1>
<form method="POST" action="{{ route('login') }}" class="auth-form flex flex-col gap-y-2 p-2 text-xl">
    {{ csrf_field() }}
    
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

    <div class="flex items-center items-center gap-x-2 mt-2">
        <input class="w-4 h-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
        <label class="flex items-center gap-x-2">Remember Me</label>
    </div>

    <div id="signin-signup-container" class="flex flex-col items-center gap-y-2 mt-2">
        <button type="submit" class="p-1 bg-green-500 border border-green-600 hover:bg-green-600 hover:cursor-pointer rounded-md w-full font-semibold text-white">Sign in</button>
        <a class="button button-outline p-1 text-base text-center w-full" href="{{ route('register') }}">New to Rabbit? <span class="text-sky-600">Create an account.</span></a>
    </div>
</form>
</section>
@endsection
