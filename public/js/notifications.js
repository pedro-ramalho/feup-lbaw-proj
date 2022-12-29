const optionLikes = document.querySelector("#opt-notification-likes");
const optionReplies = document.querySelector("#opt-notification-replies");
const optionFollows = document.querySelector("#opt-notification-follows");

const likes = document.querySelector("#like-notifications");
const replies = document.querySelector("#reply-notifications");
const follows = document.querySelector("#follow-notifications");

const notificationsOpts = [optionLikes, optionReplies, optionFollows];
const notificationsContent = [likes, replies, follows];

function showSingle(selected, opt) {
  for (const obj of notificationsContent) {
    if (obj != selected) {
      obj.style.display = "none";
    }
    else {
      obj.style.display = "flex";
    }
  }

  for (const obj of notificationsOpts) {
    if (obj != opt) {
      obj.style.fontWeight = "normal";
    }
    else {
      obj.style.fontWeight = "bold";
    }
  }
}

optionLikes.addEventListener("click", showSingle.bind(this, likes, optionLikes));
optionReplies.addEventListener("click", showSingle.bind(this, replies, optionReplies));
optionFollows.addEventListener("click", showSingle.bind(this, follows, optionFollows));