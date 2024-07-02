<?php

require_once __DIR__.'/common/session.php';
require_once __DIR__.'/common/request.php';

$postId = query_get_positive_int('id');

if ($postId === null) {
    header('Location: /');
    exit;
}

/** @var PostRepository $postRepository */
$postRepository = require_once __DIR__.'/src/Repository/PostRepository.php';

$post = $postRepository->getById($postId);
if ($post === null) {
    // TODO not found page
    header('Location: /');
    exit;
}

// determine whether a current user is can manage post
//$isCanManagePost = get_user()?->getId() === $post->getAuthorId();

$user = get_user();

$userId = null;
if ($user !== null) {
    $userId = $user->getId();
}

if ($userId === $post->getAuthorId()) {
    $isCanManagePost = true;
} else {
    $isCanManagePost = false;
}

require_once __DIR__.'/templates/page/post/view.php';
