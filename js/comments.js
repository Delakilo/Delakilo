function toggleCommentLike(idComment) {
    let sectionComment = document.getElementById('comment_' + idComment)
    let imgCommentLike = sectionComment.querySelector('footer > button > img')
    let action = imgCommentLike.alt
    let nextAction = action === 'LikeComment' ? 'UnlikeComment': 'LikeComment'
    let newImage = action === 'LikeComment' ?  './resources/icons/post/heart-red.svg': './resources/icons/post/heart-empty.svg'
    $.ajax({
        url: 'utils/buttons.php',
        type: 'POST',
        data: {
            comment_id: idComment,
            action: action
        },
        success: function (response) {
            if (response.status == 'OK') {
                imgCommentLike.src = newImage
                imgCommentLike.alt = nextAction
            } else {
                console.error(response.status)
            }
        },
        error: function (error) {
            console.error(error)
        }
    });
}

function submitComment(event, idPost) {
    // Avoids form to submit in a synchronous way
    event.preventDefault()
    let comment = document.getElementById('add_comment').value
    $.ajax({
        type: 'POST',
        url: 'utils/submitComment.php',
        data: {
            post_id: idPost,
            comment: comment
        },
        success: function(response) {
            let firstSection = document.querySelector('body > main > section:first-of-type')
            firstSection.insertAdjacentHTML('beforebegin', response.comment)
            let textArea = document.querySelector('body > main > section > form > ul > li > textarea')
            textArea.value = ''
        },
        error: function (error) {
            console.error(error)
        }
    });
}

