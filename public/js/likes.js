const likeButtons = document.querySelectorAll(".like-post-button");
const dislikeButtons = document.querySelectorAll(".dislike-post-button");
const csrfToken = document.querySelector("[name='csrf-token']").content

likeButtons.forEach(function(currentBtn){
    currentBtn.addEventListener("click", ajaxLike.bind(this, currentBtn.getAttribute('data-id')));
})
dislikeButtons.forEach(function(currentBtn){
    currentBtn.addEventListener("click", ajaxDislike.bind(this, currentBtn.getAttribute('data-id')));
})

function ajaxLike(post_id){


    fetch("/post/"+parseInt(post_id)+"/like", {

    method: 'POST',
 

    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": csrfToken
    }

    }).then((response) => response.json())
    .then(response => {


    var like = document.getElementById("post"+parseInt(post_id)+"likes").textContent;

    if(response.wasLiked){

        document.getElementById("like-post"+parseInt(post_id)+"-symb").classList = "fa-solid fa-thumbs-up text-gray-500 text-3xl";
        document.getElementById("post"+parseInt(post_id)+"likes").innerHTML=parseInt(like)-1;
        document.getElementById("like-post"+parseInt(post_id)).setAttribute("data-likepressed","0");
    }
    else{
        if(document.getElementById("dislike-post"+parseInt(post_id)).getAttribute("data-dislikepressed")== "1"){
            
            var dislike = document.getElementById("post"+parseInt(post_id)+"dislikes").textContent;
            document.getElementById("dislike-post"+parseInt(post_id)+"-symb").classList = "fa-solid fa-thumbs-down text-gray-500 text-3xl";
            document.getElementById("post"+parseInt(post_id)+"dislikes").innerHTML=parseInt(dislike)-1;
            document.getElementById("dislike-post"+parseInt(post_id)).setAttribute("data-dislikepressed","0");
            
        }
        
        document.getElementById("like-post"+parseInt(post_id)+"-symb").classList = "fa-solid fa-thumbs-up text-black text-3xl";
        document.getElementById("post"+parseInt(post_id)+"likes").innerHTML=parseInt(like)+1;
        document.getElementById("like-post"+parseInt(post_id)).setAttribute("data-likepressed","1");
        }

    console.log(response);
    

}).catch((error) => {

    console.log(error)

})
}

function ajaxDislike(post_id){


    fetch("/post/"+parseInt(post_id)+"/dislike", {

    method: 'POST',
 

    headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        "X-CSRF-Token": csrfToken
    }

    }).then((response) => response.json())
    .then(response => {


    var dislike = document.getElementById("post"+parseInt(post_id)+"dislikes").textContent;

    if(response.wasDisliked){

        document.getElementById("dislike-post"+parseInt(post_id)+"-symb").classList = "fa-solid fa-thumbs-down text-gray-500 text-3xl";
        document.getElementById("post"+parseInt(post_id)+"dislikes").innerHTML=parseInt(dislike)-1;
        document.getElementById("dislike-post"+parseInt(post_id)).setAttribute("data-dislikepressed","0");
    }
    else{

        if(document.getElementById("like-post"+parseInt(post_id)).getAttribute("data-likepressed")== "1"){

            var like = document.getElementById("post"+parseInt(post_id)+"likes").textContent;
            document.getElementById("like-post"+parseInt(post_id)+"-symb").classList = "fa-solid fa-thumbs-up text-gray-500 text-3xl";
            document.getElementById("post"+parseInt(post_id)+"likes").innerHTML=parseInt(like)-1;
            document.getElementById("like-post"+parseInt(post_id)).setAttribute("data-likepressed","0");
            
        }
        document.getElementById("dislike-post"+parseInt(post_id)+"-symb").classList = "fa-solid fa-thumbs-down text-black text-3xl";
        document.getElementById("post"+parseInt(post_id)+"dislikes").innerHTML=parseInt(dislike)+1;
        document.getElementById("dislike-post"+parseInt(post_id)).setAttribute("data-dislikepressed","1");
        }

    console.log(response.wasDisliked);
    

}).catch((error) => {

    console.log(error)

})
}
