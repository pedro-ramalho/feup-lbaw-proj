<div id="community-data">
  <nav id="community-data-options">
    <ul>
      <li>Sort by:</li>
      <li>HOT</li>
      <li>NEW</li>
      <li>TOP</li>
    </ul>
  </nav>
  <div id="posts">
    @each('partials.preview_post', $community->posts()->get(), 'post')
  </div>

</div>
