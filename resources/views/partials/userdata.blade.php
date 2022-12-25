<div id="user-data" class="mt-8 w-px-896 max-w-4xl">
  @include('layouts.sort')
  <div id="profile-posts" class="flex flex-col gap-y-2 w-px-896 max-w-4xl">
    @each('partials.preview_post', $user->content()->where('is_post', TRUE)->join('post', 'content.id', '=', 'post.id')->get(), 'post')
  </div>
  <div id="profile-comments" class="flex flex-col gap-y-2 w-px-896 max-w-4xl">
    @each('partials.preview_comment', $user->content()->where('is_post', FALSE)->join('comment', 'content.id', '=', 'comment.id')->get(), 'comment')
  </div>
</div>
