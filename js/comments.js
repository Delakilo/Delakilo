function toggleCommentLike(idComment) {
    action = document.getElementById(idComment).alt;
    let nextAction = action === 'LikeComment' ? 'UnlikeComment': 'LikeComment';
    let newImage = action === 'LikeComment' ?  './resources/icons/post/heart-red.svg': './resources/icons/post/heart-empty.svg';
    $.ajax({
        url: 'utils/buttons.php',
        type: 'POST',
        data: {
            comment_id: idComment,
            action: action
        },
        success: function (response) {
            if (response.status == 'OK') {
                document.getElementById(idComment).src = newImage;
                document.getElementById(idComment).alt = nextAction;
            } else {
                console.warn(response.status);
            }
        },
        error: function (error) {
            console.error(error);
        }
    });
}