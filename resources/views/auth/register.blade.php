@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('register') }}" class="auth-form">
    {{ csrf_field() }}

    <label for="usrname">Username</label>
    <input id="usrname" type="text" name="username" value="{{ old('username') }}" required autofocus>
    @if ($errors->has('username'))
      <span class="error">
          {{ $errors->first('username') }}
      </span>
    @endif

    <label for="email">E-Mail Address</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
    @if ($errors->has('email'))
      <span class="error">
          {{ $errors->first('email') }}
      </span>
    @endif

    <label for="password">Password</label>
    <input id="password" type="password" name="password" required>
    @if ($errors->has('password'))
      <span class="error">
          {{ $errors->first('password') }}
      </span>
    @endif

    <label for="password-confirm">Confirm Password</label>
    <input id="password-confirm" type="password" name="password_confirmation" required>

    <div id="signin-signup-container">
      <button type="submit">
        Register
      </button>
      <a class="button button-outline" href="{{ route('login') }}">Login</a>
    </div>
</form>
@endsection
