<article class="comment">
  <a class="comment-info" href="{{ route('user',$comment->content->owner->id) }}">
    <i class="fa-regular fa-circle-user fa-2x"></i>
    <span class="comment-name">{{ $comment->content->owner->username }}</span>
    <span class="comment-time"><?php echo date_string(substr($comment->content['created'], 0, 19));  ?>
   </span>
  </a>
  <section class="comment-content">
    <p class="comment-text"> {{ $comment->text }}</p>
    <section class="comment-interactables">
      <div class="like"><i class="fa-regular fa-thumbs-up"></i> {{ $comment->content->likers->count()}}</div>
      <div class="dislike"><i class="fa-regular fa-thumbs-down"></i> {{ $comment->content->dislikers->count()}}</div>
      <div class="comments"><i class="fa-solid fa-comment"></i> Reply</div>
      <div class="report"><i class="fa-solid fa-flag"></i> Report</div>
    </section>
    @foreach ($comment->content->comments as $nested_comment)
      @include('partials.comment', ['comment' => $nested_comment])
    @endforeach
   </section>
</article>