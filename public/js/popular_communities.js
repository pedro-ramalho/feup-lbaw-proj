const followButtons = document.querySelectorAll(".follow-button");


followButtons.forEach(function(currentBtn){
    currentBtn.addEventListener("click", ajaxFollow.bind(this, currentBtn.getAttribute('data-id')));
})


function ajaxFollow(community_id){



    if(document.getElementById("follow-button-"+parseInt(community_id)).innerText=="Follow"){
    
        fetch("community/"+parseInt(community_id)+"/follow", {
            
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            }
        }).then((response) => {

            document.getElementById("follow-button-"+parseInt(community_id)).innerText="Followed";
        
        }).catch((error) => {

            console.log(error)
        
        }) 
    }
    else{
        fetch("community/"+parseInt(community_id)+"/unfollow", {
            
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                "X-CSRF-Token": csrfToken
            }
        }).then((response) => {

            document.getElementById("follow-button-"+parseInt(community_id)).innerText="Follow";
        
        }).catch((error) => {

            console.log(error)
        
        }) 
    }
}
               
