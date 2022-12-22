<div id="user-data" class="mt-8">
  @include('layouts.sort')
  @each('partials.preview_post', $user->content()->where('is_post', TRUE)->join('post', 'content.id', '=', 'post.id')->get(), 'post')
</div>
