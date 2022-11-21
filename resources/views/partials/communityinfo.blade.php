<div id="community-info">
  <div id="community-banner">
    <p>Banner</p>
  </div>
  <section id="community-details">
    <div id="community-img-name">
      <img src="{{ asset('img/icon/carrot.svg') }}">
      <div id="name_com">
        <p id="name">{{ $community->name }}</p>
        <p id="c_slash">c/{{ $community->name }}</p>
      </div>
    </div>
  </section>
</div>