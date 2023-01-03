const followButton = document.querySelector('.user-follow-button');

followButton.addEventListener("click", ajaxFollow.bind(this, followButton.getAttribute('data-id')));

/*
followButton.addEventListener('click', (e) => {
  const idClassName = followButton.classList.item(0);
  const substrings = idClassName.split("-");
  const userId = parseInt(substrings[substrings.length - 1]);
  
})
*/

function ajaxFollow(id){

  fetch("/user/"+parseInt(id)+"/follow",{
    
    method: 'POST',

    headers: {
      'Accept': 'application/json',
      'Content-Type': 'application/json',
      "X-CSRF-Token": csrfToken
  }
}).then((response) => {

  const button = document.querySelector('.user-follow-button');
  const followCounter = document.querySelector('#user-num-followers p span');
  if (button.textContent === "Follow") {
    button.textContent = "Followed";
    let numbCounter = parseInt(followCounter.textContent);
    numbCounter += 1;
    followCounter.textContent = numbCounter;
  } else {
    button.textContent = "Follow";
    let numbCounter = parseInt(followCounter.textContent);
    numbCounter -= 1;
    followCounter.textContent = numbCounter;
  }

}).catch((error) => {

  console.log(error)

}) 


}