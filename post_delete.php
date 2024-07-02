<?php

require_once __DIR__.'/common/session.php';
require_once __DIR__.'/common/request.php';

$user = get_user();
if ($user === null) {
    header('Location: /');
    exit;
}

$postId = query_get_positive_int('id');

/** @var $postRepository PostRepository */
$postRepository = require_once __DIR__.'/src/Repository/PostRepository.php';
$currentUser = $postRepository->getById($postId);

if ($currentUser->getAuthorId() !== $user->getId()) {
    header('Location: /');
    exit;
}

$postRepository->remove($postId);
unlink(__DIR__.'/uploads/'.$postId);

header('Location: /');
