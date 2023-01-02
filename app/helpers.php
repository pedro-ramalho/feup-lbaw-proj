<?php

use App\Models\Comment;
use App\Models\Content;
use Illuminate\Support\Facades\DB;


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


function hi() {
  echo 'hi';
}

?>
