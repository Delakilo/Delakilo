function toggleFollow(idUser) {
    let userSection = document.getElementById('user_' + idUser)
    let button = userSection.querySelector('footer > button')
    let action = button.innerText
    let nextAction = button.innerText === 'Follow' ? 'Unfollow' : 'Follow'
    $.ajax({
        url: 'submits/buttons.php',
        type: 'POST',
        data: {
            user_id: idUser,
            action: action
        },
        success: function (response) {
            if (response.status == 'OK') {
                button.innerText = nextAction
                nFollowers = userSection.querySelector('div > ul > li:nth-child(2) > a')
                let matches = nFollowers.textContent.match(/\d+/)
                if (matches) {
                    let currentFollowersCount = parseInt(matches[0])
                    let nexFollowersCount
                    if (action === 'Follow') {
                        nexFollowersCount = currentFollowersCount + 1
                    } else {
                        nexFollowersCount = currentFollowersCount - 1
                    }
                    nFollowers.innerHTML = nexFollowersCount + `<br/>Followers`
                }
            } else {
                console.warn(response.status)
            }
        },
        error: function (error) {
            console.log(error)
        }
    });
}