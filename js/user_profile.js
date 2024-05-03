function toggleFollow(idUser) {
    let button = document.getElementById(idUser)
    let nextValue = button.innerText === 'Follow' ? 'Unfollow': 'Follow'
    $.ajax({
        url: 'utils/buttons.php',
        type: 'POST',
        data: {
            user_id: idUser,
            action: button.innerText
        },
        success: function (response) {
            if (response.status == 'OK') {
                button.innerText = nextValue
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}