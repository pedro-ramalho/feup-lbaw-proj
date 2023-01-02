<article class="preview-comment max-w-4xl w-full flex flex-col gap-y-4 p-4 border-2 border-gray-300 rounded-sm">
  <div id="comment-header" class="flex gap-x-2 items-center pb-2 border-b">
    <i class="fa-sharp fa-solid fa-user text-xl"></i>
    <p class="text-sm"><span class="font-semibold"><?= get_comment_author($comment->id) ?></span> <span class="font-light">commented on</span><span class="font-semibold italic"><?= get_comment_community($comment->id) ?></span><span class="font-light"> 8 days ago</span></p>
  </div>
  <p class="text-lg">{{ $comment->text }}</p>
  <div id="comment-interactables" class="flex gap-x-24 items-center">
    <div class="preview-comment-rating flex gap-x-4 items-center">
      <div id="preview-comment-like" class="flex gap-x-2 items-center">
        <i class="fa-solid fa-thumbs-up text-gray-500 text-3xl"></i>
        <p class="font-normal"><span><?= get_rating($comment->id, TRUE) ?></span></p>
      </div>
      <div id="preview-comment-dislike" class="flex gap-x-2 items-center">
        <i class="fa-solid fa-thumbs-down text-gray-500 text-3xl"></i>
        <p><span><?= get_rating($comment->id, FALSE) ?></span></p>
      </div>
    </div>
    <div id="preview-post-report" class="flex gap-x-2 items-center">
      <i class="fa-solid fa-flag text-gray-500 text-3xl"></i>
      <p class="font-medium">Report post</p>
    </div>
  </div>  
</article>