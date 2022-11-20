<div id="community-info">
  <div id="community-banner">
    <p>Banner</p>
  </div>
  <section id="community-details">
    <div id="community-img-name">
      <img src="{{ asset('img/tux-nightcap.svg') }}">
      <div id="name_com">
        <p id="name">{{ $community->name }}</p>
        <p id="c_slash">c/{{ $community->name }}</p>
        <p>{{ $community->description }}</p>
      </div>
    </div>
  </section>
</div>