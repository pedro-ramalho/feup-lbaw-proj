<section class="preview-user">
  <a class="pu-image-name" href="{{ route('user', $user->id) }}">
    <img src="{{ asset('img/icon/profile.svg') }}" alt="profile picture" class="pu-profile-pic">
    <p class="pu-username"> {{ $user->username }}</p>
  </a>
    <p class="pu-bio"> {{ $user->biography }}</p>
</section>
