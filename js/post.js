function togglePostLike(idPost) {
    action = document.getElementById(idPost).alt;
    let nextAction = action === 'LikePost' ? 'UnlikePost': 'LikePost';
    let newImage = action === 'LikePost' ?  './resources/icons/post/heart-red.svg': './resources/icons/post/heart-empty.svg';
    $.ajax({
        url: 'utils/buttons.php',
        type: 'POST',
        data: {
            post_id: idPost,
            action: action
        },
        success: function (response) {
            if (response.status == 'OK') {
                document.getElementById(idPost).src = newImage;
                document.getElementById(idPost).alt = nextAction;
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function commentPost() {
    window.alert('COMMENT TODO');
}
