<div id="community-data">
  <nav id="community-data-options">
    <ul>
      <h2>Sort by:</h2>
      <li>HOT</li>
      <li>NEW</li>
      <li>TOP</li>
    </ul>
  </nav>
  <div id="posts">
    @each('partials.preview_post', $community->posts()->get(), 'post')
  </div>

</div>
