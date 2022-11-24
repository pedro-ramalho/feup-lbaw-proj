<?php
use App\Models\Community;
?>
<div id="community-banner">
  <div id="banner">
    <p></p>
  </div>
  <section id="community-details">
    <div id="community-img-name">
      <img src="{{ asset('img/icon/carrot.svg') }}">
      <div id="name-com">
        <p id="name">{{ $community->name }}</p>
        <p id="c-slash">c/{{ $community->name }}</p>
      </div>
    </div>
  </section>
</div>