<?php

function date_string($date_string)
{
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