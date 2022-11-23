<section id="about-community">
  <div>
    <h1>About Community</h1>
  </div>
  <div id="community-image-name">
    <img src="{{ asset('img/icon/carrot.svg') }}" alt="community icon">
    <a href="{{ route('community', $community->id) }}"> c/{{ $community->name }}</a>
  </div>
  <p id="community-description"> {{ $community['description']}}</p>
  <div id="created-members">
    <div id="created-on">
      <p><i class="fa-solid fa-carrot"></i> <span>Created on</span></p>
      <p>{{ substr($community->founded, 0, 10) }}</p>
    </div>
    <div id="members-number">
      <p><i class="fa-solid fa-user"></i>  <span>Members</span></p>
      <p> {{ $community->user_follow_community()->where('id_followee', $community->id)->get()->count()}}</p>
    </div>
  </div>
  @auth
    @if (Auth::user()->follows->contains($community))
      <form action="{{ route('unfollow', $community->id) }}" method="post" class="form-button">
        {{ csrf_field() }}
        <button class="unfollow-community-button" type="submit">Unfollow</button>
      </form>
    @else
      <form action="{{ route('follow', $community->id) }}" method="post" class="form-button">
        {{ csrf_field() }}
        <button class="follow-community-button" type="submit">Follow</button>
      </form>
    @endif
  @endauth
  @guest
    <a class="follow-community-button" href="{{ route('login') }}">Follow</a>
  @endguest
</section>
