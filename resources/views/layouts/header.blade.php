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
      <nav id="navigation-options" class="show bg-gray-800 right-4 rounded-md w-60 border-2 border-slate-700 absolute">
        <ul class="list-none flex flex-col">
          <li class="inline-block pl-4 py-2 hover:bg-gray-700"><a href="/">Home</a></li>
          <div id="your-options" class="flex flex-col border-t border-b border-slate-700 p-0">
            <li class="inline-block pl-4 py-2 hover:bg-gray-700"><a href="/">Your profile</a></li>
            <li class="inline-block pl-4 py-2 hover:bg-gray-700"><a href="/">Your notifications</a></li>
            <li class="inline-block pl-4 py-2 hover:bg-gray-700"><a href="/">Your posts</a></li>
            <li class="inline-block pl-4 py-2 hover:bg-gray-700"><a href="/">Your comments</a></li>
          </div>
          <div id="platform-options" class="flex flex-col border-b border-slate-700 p-0">
            <li class="inline-block pl-4 py-2 hover:bg-gray-700"><a href="/">About Us</a></li>
            <li class="inline-block pl-4 py-2 hover:bg-gray-700"><a href="/">Help</a></li>
          </div>
          <li class="inline-block pl-4 py-2 hover:bg-gray-700"><a href="/">Sign Out</a></li>
          
        </ul>
      </nav>
    </div>
  </div>
  @else
  <div id="header-signup-container" class="flex justify-center gap-x-4">
    <a href="{{ route('login') }}" id="header-signin" class="p-1 font-medium">Sign in</a>
    <a href="{{ route('register') }}" id="header-signup" class="p-1 border border-2-white rounded-lg font-medium">Sign up</a>
  </div>
  @endif
</header>