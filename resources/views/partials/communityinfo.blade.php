<?php
use App\Models\Community;
?>
<div id="community-banner">
  <div id="banner">
    <p>Banner</p>
  </div>
  <section id="community-details">
    <div id="community-img-name">
      <img src="{{ asset('img/icon/carrot.svg') }}">
      <div id="name_com">
        <p id="name">{{ $community->name }}</p>
        <p id="c_slash">c/{{ $community->name }}</p>
        @if (Auth::user()->community->contains(Community::find($community->id)))
        <a id="edit-community-button" href="{{ route('edit_community', $community->id) }}"><i class="fa-solid fa-pen"></i> Edit community</a>
        @endif
      </div>
    </div>
  </section>
</div>