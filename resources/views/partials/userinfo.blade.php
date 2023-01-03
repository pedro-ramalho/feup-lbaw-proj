<div id="user-info" class="mt-8 flex flex-col items-center gap-y-4">
  <div id="user-img-username" class="flex flex-col items-center gap-y-2">
    <img src="{{ url(get_pfp_path(Auth::user()->id)) }}" class="profile-pfp rounded-full border-2 border-gray-700">
    <p id="username" class="text-xl font-semibold">{{ $user->username }}</p>
  </div>
  <div id="cday-rep-container" class="flex gap-x-6 justify-between text-xl">
    <div id="carrot-day" class="flex items-center gap-x-2">
      <i class="fa-solid fa-calendar"></i>
      <p><span>{{ date('Y-m-d', strtotime($user->register_date))}}</span></p>
    </div>
    <div id="reputation" class="flex items-center gap-x-2">
      <i class="fa-solid fa-trophy text-lg"></i>
      <p><span class="font-semibold text-green-500">30</span> reputation</p>
    </div>
  </div>
  <article id="user-biography">
    @if (Auth::user()->id === $user->id)
      <div class="flex items-center gap-x-2 text-lg">
        <p class="text-left">{{ $user->biography }}</p>
        <a href="{{ route('edit', $user->id) }}"><i class="fa-solid fa-pen"></i></a>
      </div>
    @else 
      <p class="text-left">{{ $user->biography }}</p>
    @endif
  </article>
  <div id="user-misc" class="flex gap-x-4 text-lg">
    <div id="user-num-followers" class="flex items-center gap-x-2">
      <i class="fa-solid fa-users text-gray-500"></i>
      <p class="font-light"><span class="font-medium"><?= get_num_followers($user->id) ?></span> followers</p>
    </div>
    <div id="user-num-posts" class="flex items-center gap-x-2">
      <i class="fa-solid fa-message text-gray-500"></i>
      <p class="font-light"><span class="font-medium">{{ $user->content()->where('is_post', TRUE)->get()->count() }}</span> posts</p>
    </div>
    <div id="user-num-comments" class="flex items-center gap-x-2">
      <i class="fa-solid fa-comment text-gray-500"></i>
      <p class="font-light"><span class="font-medium">{{ $user->content()->where('is_post', FALSE)->get()->count() }}</span> comments</p>
    </div>
  </div>
</div>