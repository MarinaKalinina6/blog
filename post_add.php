<?php

declare(strict_types=1);

require_once __DIR__.'/common/database.php';
require_once __DIR__.'/common/session.php';
require_once __DIR__.'/common/request.php';

$user = get_user();
if ($user === null) {
    header('Location: /');
    exit;
}

$title = '';
$text = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = post_get_string('title');
    $text = post_get_string('text');
    $file = $_FILES['file'];

    if ($title === '' && $text === '') {
        $errors[] = 'Please enter title and text.';
    } else {
        if (mb_strlen($title) > 50) {
            $errors[] = 'Please, enter less title';
        }
        if ($title === '') {
            $errors[] = 'Please enter title';
        }
        if (mb_strlen($text) > 1000) {
            $errors[] = 'Please, enter less text';
        }
        if ($text === '') {
            $errors[] = 'Please enter text';
        }
    }

    if ($file['error'] !== UPLOAD_ERR_OK) {
        $errors[] = match ($file['error']) {
            UPLOAD_ERR_INI_SIZE => 'The file exceeds the max filesize.',
            UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the max size file.',
            UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
            UPLOAD_ERR_NO_FILE => 'Please upload a file.',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
            UPLOAD_ERR_EXTENSION => 'Stopped the file upload.',
            default => 'Cannot upload a file. Please try again.',
        };
    }
    if ($file['error'] === UPLOAD_ERR_OK && $file['type'] !== 'image/jpeg') {
        $errors[] = 'File must be in jpg format.';
    }

    if ($errors === []) {
        $connection = database_connect();
        $connection->beginTransaction();

        /** @var $postRepository PostRepository */
        $postRepository = require_once __DIR__.'/src/Repository/PostRepository.php';
        $postId = $postRepository->insert($user->getId(), $title, $text);

        $pathFile = __DIR__.'/uploads/'.$postId;
        $moveFile = move_uploaded_file($file['tmp_name'], $pathFile);
        if ($moveFile === false) {
            $errors[] = 'Cannot move uploaded file. Please try again.';

            $connection->rollBack();
        } else {
            $connection->commit();
        }

        if ($errors === []) {
            header('Location: /');
            exit;
        }
    }
}
require_once __DIR__.'/templates/page/post/add.php';