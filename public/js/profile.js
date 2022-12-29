const optionOverview = document.querySelector("#opt-overview");
const optionPosts = document.querySelector("#opt-posts");
const optionComments = document.querySelector("#opt-comments");
const optionLiked = document.querySelector("#opt-liked");
const optionDisliked = document.querySelector("#opt-disliked");
const optionFavorited = document.querySelector("#opt-favorites");

const posts = document.querySelector("#profile-posts");
const comments = document.querySelector("#profile-comments");
const liked = document.querySelector("#liked-content");
const disliked = document.querySelector("#disliked-content");
const favorited = document.querySelector("#favorited-content");

const opts = [optionOverview, optionPosts, optionComments, optionLiked, optionDisliked, optionFavorited];
const content = [posts, comments, liked, disliked, favorited];

function showAll() {
  for (const obj of content) {
    obj.style.display = "flex";
  }

  for (const obj of opts) {
    if (obj != optionOverview) {
      obj.style.fontWeight = "normal";
    }
    else {
      obj.style.fontWeight = "bold";
    }
  }
}

function showSingle(selected, opt) {
  for (const obj of content) {
    if (obj != selected) {
      obj.style.display = "none";
    }
    else {
      obj.style.display = "flex";
    }
  }

  for (const obj of opts) {
    if (obj != opt) {
      obj.style.fontWeight = "normal";
    }
    else {
      obj.style.fontWeight = "bold";
    }
  }
}

optionOverview.addEventListener("click", showAll);
optionPosts.addEventListener("click", showSingle.bind(this, posts, optionPosts));
optionComments.addEventListener("click", showSingle.bind(this, comments, optionComments));
optionLiked.addEventListener("click", showSingle.bind(this, liked, optionLiked));
optionDisliked.addEventListener("click", showSingle.bind(this, disliked, optionDisliked));
optionFavorited.addEventListener("click", showSingle.bind(this, favorited, optionFavorited));