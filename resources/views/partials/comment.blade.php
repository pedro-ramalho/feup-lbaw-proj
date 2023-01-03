<article class="comment">
  <a class="comment-info" href="{{ route('user',$comment->content->owner->id) }}">
    <img src="{{ url(get_pfp_path( get_comment_author_id($comment->id))) }}" class="header-pfp rounded-full border-2 border-white">
    <span class="comment-name">{{ $comment->content->owner->username }}</span>
    <span class="comment-time"><?php echo date_string(substr($comment->content['created'], 0, 19));  ?>
   </span>
  </a>
  <section class="comment-content">
    <p class="comment-text"> {{ $comment->text }}</p>
    <section class="comment-interactables">
      <div class="like"><i class="fa-regular fa-thumbs-up"></i> {{ $comment->content->likers->count()}}</div>
      <div class="dislike"><i class="fa-regular fa-thumbs-down"></i> {{ $comment->content->dislikers->count()}}</div>
      <div class="comments"><i class="reply-button fa-solid fa-comment"></i> Reply</div>
      <form method="POST" action="{{ route('reply', $comment->id) }}" class="reply flex justify-center items-center gap-x-2">
          {{ csrf_field() }}
          <textarea name="reply-text" class="p-2 rounded-md border border-gray-500" id="post-comment-text" placeholder="Write your reply..."></textarea>
          <button type="submit" class="p-1 rounded-md h-2/4 bg-sky-500 text-white font-medium hover:cursor-pointer hover:bg-sky-600">Reply</button>
      </form>
      <div class="report"><i class="fa-solid fa-flag"></i> Report</div>
    </section>
    @foreach ($comment->content->comments as $nested_comment)
      @include('partials.comment', ['comment' => $nested_comment])
    @endforeach
   </section>
</article>