<?php
    require_once('../config.php');

    function upload_profile($log, $db, $image, $username, $name, $surname, $bio) {
        if ($image != null) {
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
            $imageFile = 'profile'.$fileExtension;
            $fullPath = '../'.get_current_user_profile($imageFile);
            $oldFullPath = '../'.get_current_user_profile($db->userGetMyImageProfile());
            if (!move_uploaded_file($fileTmpPath, $fullPath)) {
                $log->logError('Unable to upload image in "'.$fullPath.'".');
                return 'Error in uploading image in '.$fullPath.'.';
            }
            if ($fullPath != $oldFullPath && !unlink($oldFullPath)) {
                $log->logError('Unable to delete old profile image at "'.$oldFullPath.'".');
            } else {
                $db->userEditProfileWithImage($username, $name, $surname, $bio, $imageFile);
            }
        } else {
            $db->userEditProfile($username, $name, $surname, $bio);
        }
        return '';
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $image = null;
        $username = '';
        $name = '';
        $surname = '';
        $bio = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $image = $_FILES['image'];
        }
        if (isset($_POST['username'])) {
            $username = $_POST['username'];
        }
        if (isset($_POST['name'])) {
            $name = $_POST['name'];
        }
        if (isset($_POST['surname'])) {
            $surname = $_POST['surname'];
        }
        if (isset($_POST['bio'])) {
            $bio = $_POST['bio'];
        }
        $result = upload_profile($log, $db, $image, $username, $name, $surname, $bio);
        if ($result === '') {
            link_to('profile.php');
        }
        link_to('profile.php?edit&error_message='.urlencode($result));
    } else {
        $log->logFatalError('Script called without POST method');
    }
?>
