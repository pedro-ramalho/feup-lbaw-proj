
<article id="reply-notification-{{$notif->id}}" class="notification flex text-xl items-center border-2 p-4 rounded-sm">
  <a href="{{ route('user', $notif->id_triggered) }}" id="user-field" class="flex items-center gap-x-2 mr-1">
    <i class="fa-sharp fa-solid fa-user text-3xl text-gray-700"></i>
    <p class="text-black font-medium"><?= get_username($notif->id_triggered) ?></p>
  </a>
  <p class="text-gray-900 font-light">liked your
    @if(is_parent_post($notif->id_comment))
      <a href="/" class="text-sky-500">post</a> 
    @else
      <a href="/" class="text-sky-500">comment</a>
    @endif
      <?php echo date_string(substr($notif->created, 0, 19)) ?> 
  </p>
  <i class="delete-reply-notification fa-solid fa-trash ml-auto text-red-600 hover:cursor-pointer" data-id="{{$notif->id}}"></i>
</article>
