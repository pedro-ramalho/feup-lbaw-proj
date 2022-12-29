<section class="preview-user w-px-512 max-w-4xl p-4 border-2 border-gray-300 rounded-sm">
  <a class="pu-image-name flex items-center gap-x-2 pb-2 border-b" href="{{ route('user', $user->id) }}">
    <i class="fa-sharp fa-solid fa-user text-xl"></i>
    <p class="pu-username"> {{ $user->username }}</p>
  </a>
    <p class="pu-bio pt-2"> {{ $user->biography }}</p>
</section>
