<div id="community-data">
  @include ('layouts.sort')
  <div id="posts">
    @each('partials.preview_post', $community->posts()->get(), 'post')
  </div>
</div>
