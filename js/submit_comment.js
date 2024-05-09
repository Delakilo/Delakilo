function submitComment(event, idPost) {
    event.preventDefault(); // Evita il comportamento predefinito del form (refresh della pagina)
    let comment = document.getElementById('add_comment').value;
    $.ajax({
        type: 'POST',
        url: 'utils/submitComment.php',
        data: {
            post_id: idPost,
            comment: comment
        },
        success: function(response) {
            // window.alert('OK');
            let firstSection = document.querySelector('main > section:first-of-type');
            firstSection.before(response.comment);
        },
        error: function (error) {
            // window.alert('ERROR');
            console.error(error);
        }
    });
}
