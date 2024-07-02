<?php

declare(strict_types=1);

final class PostController
{
    public function __construct(private readonly PostRepository $postRepository)
    {
    }

    public function main()
    {
        require_once __DIR__.'/../../common/session.php';
        require_once __DIR__.'/../../common/request.php';

        $user = get_user();

        $page = query_get_positive_int('page') ?? 1;

        $numberPost = 3;
        $passPost = ($page * $numberPost) - $numberPost;

        $posts = $this->postRepository->getByLimit($passPost, $numberPost);
        $sumPosts = $this->postRepository->countPosts();
        $sumPage = (int)ceil($sumPosts / $numberPost);
        if ($sumPage === 0) {
            $sumPage = 1;
        }
        if ($page > $sumPage) {
            header('Location: /?page='.$sumPage);
        }

        require_once __DIR__.'/../../templates/page/index.php';
    }

    public function show(int $postId)
    {
        require_once __DIR__.'/../../common/session.php';

        $post = $this->postRepository->getById($postId);
        if ($post === null) {
            header('Location: /');
            exit;
        }

        // determine whether a current user is can manage post
        $isCanManagePost = get_user()?->getId() === $post->getAuthorId();

        require_once __DIR__.'/../../templates/page/post/view.php';
    }
}
