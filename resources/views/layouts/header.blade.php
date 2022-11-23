<header>
<div id="logo-container">
    <a id="logo" href="/">Rabbit</a>
  </div>
  <div id="search-bar-container">
    <form id="search-bar" autocomplete="off" method="get" action="{{ route('search') }}">
      <i class="fa-solid fa-magnifying-glass"></i>
      <input type="search" name="q" id="query" placeholder="Search Rabbit..." autocomplete="off">
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