<section class="preview-post flex flex-col gap-y-4 p-4 border-2 border-gray-300 max-w-4xl rounded-sm">
  <h2 class="text-2xl font-medium self-start"><a href="{{ route('post', $post->id) }}">{{ $post->title }}</a></h2>
  <p class="p-2 font-medium bg-green-500 rounded-md text-center w-fit text-white">TAG</p>
  <div class="flex gap-x-24">
    <div class="preview-post-rating flex gap-x-4">
      <div id="preview-post-like" class="flex gap-x-2 items-center">
        @auth
          @if ($post->content->likers->contains(Auth::user()))
            <button id="like-post{{$post->id}}" data-id="{{$post->id}} " class="like-post-button" type="submit" data-likepressed="1">
              <i id="like-post{{$post->id}}-symb" class="fa-solid fa-thumbs-up text-black text-3xl"></i>
            </button>
          @else
            <button id="like-post{{$post->id}}" data-id="{{$post->id}}" class="like-post-button" type="submit" data-likepressed="0">
              <i id="like-post{{$post->id}}-symb" class="fa-solid fa-thumbs-up text-gray-500 text-3xl"></i>
            </button>
          @endif
        @endauth
        @guest
          <i class="fa-solid fa-thumbs-up text-gray-500 text-3xl"></i>
        @endguest
        <p class="font-normal" id="post{{$post->id}}likes"> <span>{{ $post->likes }}</span></p>
      </div>
      <div id="preview-post-dislike" class="flex gap-x-2 items-center">
        @auth
          @if ($post->content->dislikers->contains(Auth::user()))
            <button id="dislike-post{{$post->id}}" data-id="{{$post->id}} " class="dislike-post-button" type="submit" data-dislikepressed="1">
              <i id="dislike-post{{$post->id}}-symb" class="fa-solid fa-thumbs-down text-black text-3xl"></i>
            </button>
          @else
            <button id="dislike-post{{$post->id}}" data-id="{{$post->id}}" class="dislike-post-button" type="submit" data-dislikepressed="0">
              <i id="dislike-post{{$post->id}}-symb" class="fa-solid fa-thumbs-down text-gray-500 text-3xl"></i>
            </button>
          @endif
        @endauth
        @guest
          <i class="fa-solid fa-thumbs-down text-gray-500 text-3xl"></i>
        @endguest
        <p class="font-normal" id="post{{$post->id}}dislikes"> <span>{{$post->dislikes}}</span></p>
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
      @auth
        <a href="{{ route('report_post', $post->id) }}">
          <i class="fa-solid fa-flag text-gray-500 text-3xl"></i>
          <p class="font-medium">Report post</p>   
        </a>
      @endauth
      @guest
      <i class="fa-solid fa-flag text-gray-500 text-3xl"></i>
      <p class="font-medium">Report post</p>
      @endguest
    </div>
  </div>
</section>
