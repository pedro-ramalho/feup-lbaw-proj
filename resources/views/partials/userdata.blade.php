<div id="user-data">
  <nav id="user-data-options">
    <ul>
      <li>Sort by:</li>
      <li>HOT</li>
      <li>NEW</li>
      <li>TOP</li>
    </ul>
  </nav>
  @each('partials.preview_post', $user->content()->where('is_post', TRUE)->join('post', 'content.id', '=', 'post.id')->get(), 'post')
</div>
