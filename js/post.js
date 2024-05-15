function togglePostLike(idPost) {
    let postArticle = document.getElementById('post_' + idPost)
    let postImgLike = postArticle.querySelector('footer > button > img')
    let action = postImgLike.alt
    let nextAction = action === 'LikePost' ? 'UnlikePost': 'LikePost'
    let newImage = action === 'LikePost' ?  './resources/icons/post/heart-red.svg': './resources/icons/post/heart-empty.svg'
    $.ajax({
        url: 'utils/buttons.php',
        type: 'POST',
        data: {
            post_id: idPost,
            action: action
        },
        success: function (response) {
            if (response.status == 'OK') {
                postImgLike.src = newImage
                postImgLike.alt = nextAction
                let nLikes = postArticle.querySelector('aside > p > small')
                let matches = nLikes.textContent.match(/\d+/)
                if (matches) {
                    let currentLikes = parseInt(matches[0])
                    let updatedString
                    if (action === 'LikePost') {
                        updatedString = nLikes.textContent.replace(/\d+/, currentLikes + 1)
                    } else {
                        updatedString = nLikes.textContent.replace(/\d+/, currentLikes - 1)
                    }
                    nLikes.textContent = updatedString
                }
            } else {
                console.warn(response.status)
            }
        },
        error: function (error) {
            console.error(error)
        }
    });
}
