<section class="preview-post">
  <div id="preview-post-header">
    <h1>{{ $post->title }}</h1>
    <a href="{{ route('post', $post->id) }}">
      <img src="{{ asset('img/icon/expand.svg') }}" class="user-data-icon">
    </a>
  </div>
  <p class="preview-post-tag">TAG</p>
  <div class="preview-post-actions">
    <div class="preview-post-rating">
      <div id="preview-post-like" class="user-data-icon-container">
        <img src="{{ asset('img/icon/like.svg') }}" class="user-data-icon">
        <p>{{ $post->likes }}</p>
      </div>
      <div id="preview-post-dislike" class="user-data-icon-container">
        <img src="{{ asset('img/icon/dislike.svg') }}" class="user-data-icon">
        <p>{{ $post->dislikes }}</p>
      </div>
    </div>
    <div id="preview-post-comment" class="user-data-icon-container">
      <img src="{{ asset('img/icon/comment.svg') }}" class="user-data-icon">
      <p>17</p>
    </div>
    <div id="preview-post-favorite" class="user-data-icon-container">
      <img src="{{ asset('img/icon/favorite.svg') }}" class="user-data-icon">
      <p>Add to favorites</p>
    </div>
    <div id="preview-post-report" class="user-data-icon-container">
      <img src="{{ asset('img/icon/report.svg') }}" class="user-data-icon">
      <p>Report post</p>
    </div>
  </div>
</section>
