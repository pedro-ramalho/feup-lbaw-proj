const likeButtons = document.querySelectorAll(".like-post-button");
const dislikeButtons = document.querySelectorAll(".dislike-post-button");

likeButtons.forEach(function(currentBtn){
    currentBtn.addEventListener("click", ajaxLike);
})





function ajaxLike(){

    var post_id = $(this).data('id');

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type:'Post',
        url:'/post/like',
        data:{post_id:post_id},
        success:function(data){
            console.log(data);
        }
    });
}

