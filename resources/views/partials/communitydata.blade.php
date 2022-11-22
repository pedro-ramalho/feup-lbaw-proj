<div id="community-data">
  <nav id="community-data-options">
    <ul>
      <h2>Sort by:</h2>
      <li><i class="fa fa-fire"></i> HOT</li>
      <li><i class="fa-solid fa-certificate"></i> NEW</li>
      <li><i class="fa-solid fa-chart-line"></i> TOP</li>
    </ul>
  </nav>
  <div id="posts">
    @each('partials.preview_post', $community->posts()->get(), 'post')
  </div>

</div>
