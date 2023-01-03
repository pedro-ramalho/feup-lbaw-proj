

<article id="like-notification-{{$notif->id}}" class="notification flex text-xl items-center border-2 p-4 rounded-sm">
  <a href="{{ route('user', $notif->id_triggered) }}" id="user-field" class="flex items-center gap-x-2 mr-1">
    <img src="{{ url(get_pfp_path($notif->id_triggered)) }}" class="notif-pfp rounded-full border-2 border-gray-700">
    <p class="text-black font-medium"><?= get_username($notif->id_triggered) ?></p>
  </a>
  <p class="text-gray-900 font-light">liked your
    
    @if($notif->is_post)
      <a href="{{ route('post', $notif->id_content) }}" class="text-sky-500">post</a> 
    @else
      <a href="{{ route('post', $notif->id_content) }}" class="text-sky-500">comment</a>
    @endif
      <?php echo date_string(substr($notif->created, 0, 19)) ?> 
  </p>
  <i class="delete-like-notification fa-solid fa-trash ml-auto text-red-600" data-id="{{$notif->id}}"></i>
</article>
