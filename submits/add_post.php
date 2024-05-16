<?php
    require_once('../config.php');

    function upload_post_image($db, $image, $caption) {
        $fileTmpPath = $image['tmp_name'];
        $imageSize = getimagesize($fileTmpPath);
        if ($imageSize === false) {
            return 'Uploaded file is not an image! Extensions allowed are '.implode(", ", IMG_EXTENSIONS_ALLOWED).'.';
        }
        $fileType = mime_content_type($fileTmpPath);
        if (in_array($fileType, IMG_MIME_TYPES_ALLOWED) == false) {
            return 'Uploaded file mime type '.$fileType.' is invalid, extensions allowed are '.implode(', ', IMG_EXTENSIONS_ALLOWED).'.';
        }
        if ($image['size'] > IMG_MAX_SIZE_B) {
            return 'Uploaded image is too big, max size must be '.IMG_MAX_SIZE_MB.' MB.';
        }
        $fileExtension = '.'.(explode('/', $fileType)[1]);
        $post_id = $db->postAdd($fileExtension, $caption);
        $directory = '../'.get_current_user_dir_posts_path();
        $fullPath = $directory.$post_id.$fileExtension;
        if (move_uploaded_file($fileTmpPath, $fullPath) == false) {
            return 'Error in uploading image in '.$fullPath.'.';
        }
        return '';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['caption']) && isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $result = upload_post_image($db, $_FILES['image'], $_POST['caption']);
            if ($result === '') {
                header('Location: ../profile.php');
            } else {
                header('Location: ../profile.php?add_post&error_message='.urlencode($result));
            }
            exit;
        } else {
            $log->logFatalError('Script called without correct caption and image parameters of POST method');
        }
    } else {
        $log->logFatalError('Script called without POST method');
    }
?>
