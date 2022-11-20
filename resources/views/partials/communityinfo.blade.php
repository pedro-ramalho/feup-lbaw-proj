<div id="community-info">
  <section id="community-details">
    <div id="community-img-name">
      <p>Banner</p>
      <p>Profile Picture</p>
      <p>{{ $community->name }}</p>
    </div>
    <div id="community-misc">
      <p>Posts</p>
      <p>Followers</p>
      <p>{{ $community->founded }}</p>
      <p>{{ $community->tag }}</p>
    </div>
  </section>
  <article id="community-description">
    <p>{{ $community->description }}</p>
  </article>
</div>