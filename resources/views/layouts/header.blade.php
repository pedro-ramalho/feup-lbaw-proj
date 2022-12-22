<header class="sticky flex w-screen justify-between p-4 bg-gray-800 border-b-2 border-gray-700 text-white font-sans text-xl">
  <div id="logo-container">
    <a id="logo" href="/">Rabbit</a>
  </div>
  <div id="search-bar-container">
    <form id="search-bar" autocomplete="off" method="get" action="{{ route('search') }}" class="text-black">
      <i class="fa-solid fa-magnifying-glass absolute text-white left-4 text-base"></i>
      <input type="search" name="q" id="query" placeholder="Search Rabbit" autocomplete="off" class="bg-gray-900 h-10 text-base rounded-2xl border border-gray-700 pl-10">
    </form>
  </div>


  @if (Auth::check())
  <div id="header-user-profile" class="flex gap-x-6">
    @if (Auth::User()->is_admin)
      <a href="{{ route('admin') }}">Admin</a>
    @endif
    <a href="/"><i class="fa-solid fa-circle-info"></i></a>
    <a href="/"><i class="fa-solid fa-bell"></i></a>
    <a href="/"><i class="fa-solid fa-plus"></i></a>
    <div id="user-section">
      <a href="{{ route('user', Auth::id()) }}"><i class="fa-sharp fa-solid fa-user"></i></a>
      <i class="fa-solid fa-caret-down"></i>
    </div>
  </div>
  @else
  <div id="header-signup-container">
    <a href="{{ route('login') }}" id="header-signin">Sign in</a>
    <a href="{{ route('register') }}" id="header-signup">Sign up</a>
  </div>
  @endif
</header>