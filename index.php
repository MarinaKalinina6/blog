<?php

declare(strict_types=1);

require_once __DIR__.'/src/Controller/PostController.php';

$uri = $_SERVER['REQUEST_URI'];

if (preg_match('/^\/posts\/(?<post_id>\d+)$/', $uri, $matches) === 1) {
    /** @var PostRepository $postRepository */
    $postRepository = require_once __DIR__.'/src/Repository/PostRepository.php';
    (new PostController($postRepository))->show((int)$matches['post_id']);
    exit;
}

if ($uri === '/') {
    /** @var PostRepository $postRepository */
    $postRepository = require_once __DIR__.'/src/Repository/PostRepository.php';
    (new PostController($postRepository))->main();
    exit;
}

var_dump('not found');
