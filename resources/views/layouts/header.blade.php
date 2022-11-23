<header>
<div id="logo-container">
    <a id="logo" href="#">Rabbit</a>
  </div>
  <div id="search-bar-container">
    <form id="search-bar" autocomplete="off">
      <input type="search" name="query" id="query" placeholder="Search..." autocomplete="off">
    </form>
  </div>

  @if (Auth::check())
  <div id="header-user-profile">
    <a href="{{ route('logout') }}">Sign Out</a>
    <a href="{{ route('user', Auth::id()) }}">Profile</a>
  </div>
  @else
  <div id="header-signup-container">
    <a href="{{ route('login') }}" id="header-signin">Sign in</a>
    <a href="{{ route('register') }}" id="header-signup">Sign up</a>
  </div>
  @endif
</header>