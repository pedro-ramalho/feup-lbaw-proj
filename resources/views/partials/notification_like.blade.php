<?php

use App\Models\User;
use Illuminate\Support\Facades\DB;

function get_username(int $id) {
  return User::find($id)->username;
}

function date_string($date_string) {
  $date_created = date_create_from_format("Y-m-d H:i:s", $date_string);
  $now = new DateTime("now");
  $diff = $now->diff($date_created);
  if ($diff->y === 1) {
    return "1 year ago";
  } else if ($diff->y > 1) {
    return $diff->y . " years ago";
  } else if ($diff->m === 1) {
    return "1 month ago";
  } else if ($diff->m > 1) {
    return $diff->m . " months ago";
  } else if ($diff->d === 1) {
    return "1 day ago";
  } else if ($diff->d > 1) {
    return $diff->d . " days ago";
  } else if ($diff->h === 1) {
    return "1 hour ago";
  } else if ($diff->h > 1) {
    return $diff->h . " hours ago";
  } else if ($diff->d === 1) {
    return "1 minute ago";
  } else if ($diff->i > 1) {
    return $diff->i . " minutes ago";
  } else if ($diff->s === 1) {
    return "1 second ago";
  } else if ($diff->s > 1) {
    return $diff->s . " seconds ago";
  } else if ($diff->s == 0) {
    return "0 seconds ago";
  } else {
    return "error while reading dates";
  }
}

?>

<article class="notification flex text-xl items-center border-2 p-4 rounded-sm">
  <a href="{{ route('user', $notif->id_triggered) }}" id="user-field" class="flex items-center gap-x-2 mr-1">
    <i class="fa-sharp fa-solid fa-user text-3xl text-gray-700"></i>
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
  <i class="fa-solid fa-trash ml-auto text-red-600"></i>
</article>
