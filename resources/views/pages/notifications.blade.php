@extends('layouts.app')

<?php
use Illuminate\Support\Facades\DB;
use App\Models\User;

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

function get_like_notifications(int $id) {
  $notifs = DB::table('users')
            ->join('like_notification', 'users.id', '=', 'like_notification.id_received')
            ->join('content', 'content.id', '=', 'like_notification.id_content')
            ->where('users.id', '=', $id)
            ->get();
  
  return $notifs;
}

function get_reply_notifications(int $id) {
  $notifs = DB::table('users')
            ->join('reply_notification', 'users.id', '=', 'reply_notification.id_received')
            ->join('content', 'content.id', '=', 'reply_notification.id_comment')
            ->where('users.id', '=', $id)
            ->get();
  
  return $notifs;
}

function get_follow_notifications(int $id) {
  $notifs = DB::table('users')
            ->join('follow_notification', 'users.id', '=', 'follow_notification.id_received')
            ->where('users.id', '=', $id)
            ->get();
  
  return $notifs;
}

$like_notifs = get_like_notifications($user->id);
$reply_notifs = get_reply_notifications($user->id);
$follow_notifs = get_follow_notifications($user->id);
?>


@section('content')

<section id="notifications" class="flex flex-col items-center">
  <nav id="notification-options" class="bg-gray-900 text-white w-full">
    <ul class="flex justify-center p-4 gap-x-16 text-xl list-none list-inside">
      <li class="font-bold hover:cursor-pointer" id="opt-notification-likes">LIKES</li>
      <li class="hover:cursor-pointer" id="opt-notification-replies">REPLIES</li>
      <li class="hover:cursor-pointer" id="opt-notification-follows">FOLLOWS</li>
    </ul>
  </nav>
  <div id="like-notifications" class="flex flex-col gap-y-2">
    <div class="flex gap-x-2 items-center justify-center p-4">
      <i class="fa-solid fa-thumbs-up text-gray-900 text-3xl"></i>
      <h1 class="text-2xl">Like notifications</h1>
    </div>
    @foreach ($like_notifs as $notif)
      @if(!$notif->read)
        @include('partials.notification_like', ['notif' => $notif])
      @endif
    @endforeach
  </div>
  <div id="reply-notifications" class="hidden flex-col gap-y-2">
    <div class="flex gap-x-2 items-center justify-center p-4">
      <i class="fa-solid fa-comment text-gray-900 text-3xl"></i>
      <h1 class="text-2xl">Reply notifications</h1>
    </div>
    @foreach ($reply_notifs as $notif)
      @if(!$notif->read)
        @include('partials.notification_reply', ['notif' => $notif])
      @endif
    @endforeach
  </div>
  <div id="follow-notifications" class="hidden flex-col gap-y-2">
    <div class="flex gap-x-2 items-center justify-center p-4">
      <i class="fa-solid fa-users text-gray-900 text-3xl"></i>
      <h1 class="text-2xl">Reply notifications</h1>
    </div>
    @foreach ($follow_notifs as $notif)
      @if(!$notif->read)
        @include('partials.notification_follow', ['notif' => $notif])
      @endif      
    @endforeach
  </div>

</section>

@endsection