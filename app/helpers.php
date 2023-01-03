<?php

use App\Models\Comment;
use App\Models\Content;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


/**
 * Returns true if the parent of a given comment is a post and false otherwise.
 */
function is_parent_post(int $id_child_comment) {

  // retrieve current comment
  $curr_comment = Comment::find($id_child_comment);

  // retrieve parent id
  $curr_comment_parent = $curr_comment->id_parent;

  // retrieve parent content
  $parent = Content::find($curr_comment_parent);

  return $parent->is_post;
}

function get_rating(int $content_id, bool $liked) {
  $rating = DB::table('content_rate')
            ->where('id_content', '=', $content_id)
            ->where('liked', '=', $liked)
            ->count();
  
  return $rating;
}

function is_post(int $content_id) : bool {
  $ret = DB::table('content')
         ->where('content.id', '=', $content_id)
         ->get();

  return boolval($ret[0]->is_post);
}

function get_parent_post(int $comment_id) {
  $q = DB::table('comment')
       ->where('comment.id', '=', $comment_id)
       ->get();
  
  $id_parent = intval($q[0]->id_parent);

  if (is_post($id_parent)) {
    return intval($id_parent);
  }
  else {
    return get_parent_post($id_parent);
  }
}

function get_num_comments(int $post_id) {
  $t = DB::table('comment')
       ->get();

  $count = 0;

  foreach($t as $row) {
    $row_id = intval($row->id);
    if (get_parent_post($row_id) == $post_id) {
      $count++;
    }
  }

  return $count;
}

function get_comment_author(int $comment_id) : string {
  $q = DB::table('content')
       ->join('users', 'content.id_author', '=', 'users.id')
       ->where('content.id', '=', $comment_id)
       ->get();

  return strval($q[0]->username);
}

function get_comment_author_id(int $comment_id) : int {
  $q = DB::table('content')
       ->join('users', 'content.id_author', '=', 'users.id')
       ->where('content.id', '=', $comment_id)
       ->get();

  return intval($q[0]->id_author);
}

function get_comment_community(int $comment_id) : string {
  $post_id = get_parent_post($comment_id);

  $q = DB::table('post')
       ->join('community', 'community.id', '=', 'post.id_community')
       ->where('post.id', '=', $post_id)
       ->get();

    return 'c/' . strval($q[0]->name);
}

function get_pfp_path(int $user_id) {
  return 'storage/pfp/' . $user_id;
}



function get_num_followers(int $id) : int {
  $num_followers = DB::table('user_follow_user')
                   ->where('id_followee', '=', $id)
                   ->count();
  
  return $num_followers;
}


?>
