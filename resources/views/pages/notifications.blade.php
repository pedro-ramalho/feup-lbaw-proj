@extends('layouts.app')

<?php
use Illuminate\Support\Facades\DB;

function get_like_notifications(int $id) {
  $notifs = DB::table('users')
            ->join('like_notification', 'users.id', '=', 'like_notification.id_received')
            ->join('content', 'content.id', '=', 'like_notification.id_content')
            ->where('users.id', '=', $id)
            ->get();
  
  return $notifs;
}

$like_notifs = get_like_notifications($user->id);

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
    <div id="preview-comment-like" class="flex gap-x-2 items-center justify-center p-4">
      <i class="fa-solid fa-thumbs-up text-gray-900 text-3xl"></i>
      <h1 class="text-2xl">Like notifications</h1>
    </div>
    @foreach ($like_notifs as $notif)
      @include('partials.notification_like', ['notif' => $notif])
    @endforeach
  </div>
  <div id="reply-notifications">
    @include('partials.notification_reply', ['user' => $user])
  </div>
  <div id="follow-notifications">
    @include('partials.notification_follow', ['user' => $user])
  </div>

</section>

@endsection