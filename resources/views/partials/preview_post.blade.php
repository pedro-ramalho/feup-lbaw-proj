<section class="preview-post flex flex-col gap-y-4 p-4 border-2 border-gray-300 max-w-4xl rounded-sm">
  <h2 class="text-2xl font-medium self-start"><a href="{{ route('post', $post->id) }}">{{ $post->title }}</a></h2>
  <p class="p-2 font-medium bg-green-500 rounded-md text-center w-fit text-white">TAG</p>
  <div class="flex gap-x-24">
    <div class="preview-post-rating flex gap-x-4">
      <div id="preview-post-like" class="flex gap-x-2 items-center">
        <i class="fa-solid fa-thumbs-up text-gray-500 text-3xl"></i>
        <p class="font-normal"><span>5</span></p>
      </div>
      <div id="preview-post-dislike" class="flex gap-x-2 items-center">
        <i class="fa-solid fa-thumbs-down text-gray-500 text-3xl"></i>
        <p><span>2</span></p>
      </div>
    </div>
    <div id="preview-post-comment" class="flex gap-x-2 items-center">
      <i class="fa-solid fa-comment text-gray-500 text-3xl"></i>
      <p class="font-medium">17 comments</p>
    </div>
    <div id="preview-post-favorite" class="flex gap-x-2 items-center">
      <i class="fa-solid fa-heart text-gray-500 text-3xl"></i>
      <p class="font-medium">Add to favorites</p>
    </div>
    <div id="preview-post-report" class="flex gap-x-2 items-center">
      <i class="fa-solid fa-flag text-gray-500 text-3xl"></i>
      <p class="font-medium">Report post</p>
    </div>
  </div>
</section>
