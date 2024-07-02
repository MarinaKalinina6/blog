<?php

require_once __DIR__.'/common/database.php';
require_once __DIR__.'/common/session.php';
require_once __DIR__.'/common/request.php';

$user = get_user();
if ($user === null) {
    header('Location: /');
    exit;
}

$id = query_get_positive_int('id');

/** @var PostRepository $postRepository */
$postRepository = require_once __DIR__.'/src/Repository/PostRepository.php';
$post = $postRepository->getById($id);

if ($post === false) {
    header('Location: /');
    exit;
}
if ($post->getAuthorId() !== $user->getId()) {
    header('Location: /');
    exit;
}

$title = $post->getTitle();
$text = $post->getText();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = post_get_string('title');
    $text = post_get_string('text');
    $file = $_FILES['file'];

    if ($title === '' && $text === '') {
        $errors[] = 'Enter title and text';
    } else {
        if ($title === '') {
            $errors[] = 'Enter title';
        }
        if (mb_strlen($title) > 50) {
            $errors[] = 'Please, enter less title';
        }
        if ($text === '') {
            $errors[] = 'Enter text';
        }
        if (mb_strlen($text) > 1000) {
            $errors[] = 'Please, enter less text';
        }
    }

    // если фпкл загркжен
    if ($file['error'] !== UPLOAD_ERR_NO_FILE) {
        //если есть ошибкии при закрузке
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = match ($file['error']) {
                UPLOAD_ERR_INI_SIZE => 'The file exceeds the max filesize.',
                UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the max size file.',
                UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
                UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
                UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
                UPLOAD_ERR_EXTENSION => 'Stopped the file upload.',
                default => 'Cannot upload a file. Please try again.',
            };
        }
        // если фркл не jpeg
        if ($file['error'] === UPLOAD_ERR_OK && $file['type'] !== 'image/jpeg') {
            $errors[] = 'File must be in jpg format.';
        }
    }

    //если  нет ошибок
    if ($errors === []) {
        $connection = database_connect();
        $connection->beginTransaction();

        //обновляем тайтл и текст
        $postRepository->update($title, $text, $id);

        if ($file['error'] === UPLOAD_ERR_OK) {
            $pathFile = __DIR__.'/uploads/'.$post->getId();
            $isFileMoved = move_uploaded_file($file['tmp_name'], $pathFile);
            if ($isFileMoved === false) {
                $errors[] = 'Cannot move uploaded file. Please try again';
            }
        }

        if ($errors !== []) {
            $connection->rollBack();
        } else {
            $connection->commit();
            header('Location: /');
            exit;
        }
    }
}

require_once __DIR__.'/templates/page/post/edit.php';
