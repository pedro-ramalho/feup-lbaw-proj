<?php

use App\Models\Comment;
use App\Models\Content;

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

function hi() {
  echo 'hi';
}

?>
