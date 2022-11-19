<div id="user-info">
  <section id="user-details">
    <div id="user-img-username">
      <img src="{{ asset('img/icon/profile.svg') }}">
      <div id="username-rep">
        <p id="username">{{ $user->username }}</p>
        <div id="reputation-icon-container">
          <div class="user-rep-icon-container">
            <img class="user-profile-icon" src="{{asset('img/icon/star.svg')}}">
            <p>10 Reputation</p>
          </div>
        </div> 
      </div>
    </div>
    <div id="user-misc">
      <div id="user-num-posts" class="user-misc-info-container">
        <div id="posts-icon-container" class="user-info-icon-container">
          <img class="user-profile-icon" src="{{asset('img/icon/post.svg')}}">
          <p>Posts</p>
        </div>
        <p>{{ $user->content()->where('is_post', TRUE)->get()->count() }}</p>
      </div>
      <div id="user-num-comments" class="user-misc-info-container">
        <div id="comments-icon-container" class="user-info-icon-container">
          <img class="user-profile-icon" src="{{asset('img/icon/comment.svg')}}">
          <p>Comments</p>
        </div>
        <p>{{ $user->content()->where('is_post', FALSE)->get()->count() }}</p>
      </div>
      <div id="user-num-followers" class="user-misc-info-container">
        <div id="follower-icon-container" class="user-info-icon-container">
          <img class="user-profile-icon" src="{{asset('img/icon/user.svg')}}">
          <p>Followers</p>
        </div>
        <p>20</p>
      </div>
      <div id="user-carrot-day" class="user-misc-info-container">
        <div id="calendar-icon-container" class="user-info-icon-container">
          <img class="user-profile-icon" src="{{asset('img/icon/calendar.svg')}}">
          <p>Carrot Day</p>
        </div>
        <p>{{ date('Y-m-d', strtotime($user->register_date))}}</p>
      </div>
    </div>
  </section>
  <article id="user-biography">
    <p>{{ $user->biography }}</p>
  </article>
</div>