<div id="user-info">
  <section id="user-details">
    <div id="user-img-username">
      <p>Profile Picture</p>
      <p>{{ $user->username }}</p>
    </div>
    <div id="user-misc">
      <p>Posts</p>
      <p>Comments</p>
      <p>Followers</p>
      <p>{{ $user->register_date }}</p>
      <p>Reputation</p>
    </div>
  </section>
  <article id="user-biography">
    <p>{{ $user->biography }}</p>
  </article>
</div>