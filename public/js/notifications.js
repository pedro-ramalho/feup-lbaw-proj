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

const deleteLikeNotifBtn = document.querySelectorAll(".delete-like-notification");
const deleteFollowNotifBtn = document.querySelectorAll(".delete-follow-notification");
const deleteReplyNotifBtn = document.querySelectorAll(".delete-reply-notification");



const csrf = document.querySelector("[name='csrf-token']").content;

deleteLikeNotifBtn.forEach.call(deleteLikeNotifBtn, function(deleter) {
  deleter.addEventListener('click', deleteLikeNotificationRequest.bind(this, deleter.getAttribute('data-id')))
});

deleteFollowNotifBtn.forEach.call(deleteFollowNotifBtn, function(deleter) {
  deleter.addEventListener('click', deleteFollowNotificationRequest.bind(this, deleter.getAttribute('data-id')))
});

deleteReplyNotifBtn.forEach.call(deleteReplyNotifBtn, function(deleter) {
  deleter.addEventListener('click', deleteReplyNotificationRequest.bind(this, deleter.getAttribute('data-id')))
});


function deleteLikeNotificationRequest(id) {

  fetch("/likeNotification/"+parseInt(id)+"/delete",{
    
    method: 'POST',
 

    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": csrfToken
    }
  }).then((response) => {

    document.getElementById("like-notification-"+parseInt(id)).remove();

}).catch((error) => {

    console.log(error)

}) 


}

function deleteFollowNotificationRequest(id) {

  fetch("/followNotification/"+parseInt(id)+"/delete",{
    
    method: 'POST',
 

    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": csrfToken
    }
  }).then((response) => {

    document.getElementById("follow-notification-"+parseInt(id)).remove();

}).catch((error) => {

    console.log(error)

}) 


}

function deleteReplyNotificationRequest(id) {

  fetch("/replyNotification/"+parseInt(id)+"/delete",{
    
    method: 'POST',
 

    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": csrfToken
    }
  }).then((response) => {

    document.getElementById("reply-notification-"+parseInt(id)).remove();

}).catch((error) => {

    console.log(error)

}) 


}

