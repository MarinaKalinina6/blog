<?php /** @var $user array|null */ ?>
<?php /** @var $posts array */ ?>
<?php /** @var $page int */ ?>
<?php /** @var $sumPage int */ ?>

<?php $pageTitle = 'My blog'; ?>

<?php ob_start() ?>
<div class="header">Blog
    <?php if ($user !== null): ?>
        <a href="/logout.php" class="nav">logout</a>
        <a href="/post_add.php" class="nav">Add post</a>
    <?php else: ?>
        <a href="/login.php" class="nav">Login</a>
        <a href="/registration.php" class="nav">Registration</a>
    <?php endif; ?>
</div>

<div class="row">
    <div class="leftColumn">
        <div class="card">
            <?php foreach ($posts as $post): ?>

                <a href="/view_post.php?id=<?= $post->getId() ?>">
                    <div class="title"><?= htmlspecialchars($post->getTitle()) ?></div>
                </a>
                <div class="time"><?= $post->getTime() ?></div>
                <div class="post">
                    <div class="text"><?= htmlspecialchars($post->getText()) ?>
                    </div>
                    <div class="img">
                        <?php $image = $post->getId(); ?>
                        <img src="/uploads/<?= $image ?>" width="350px">
                    </div>
                </div>
                <div class="author">
                    Author: <?= $post->getAuthorName() ?? 'deleted user'; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="navigation">
            <?php if ($page !== 1) {
                $newerPosts = $page - 1;
                echo '<a class ="navigation_name" href="/?page='.$newerPosts.'">Newer posts</a>';
            }
            if ($page >= 1 && $page !== $sumPage) {
                $olderPostsPage = $page + 1;
                echo '<a class ="navigation_name" href="/?page='.$olderPostsPage.'">Older posts</a>';
            } ?>
        </div>
    </div>

    <div class="rightColumn">
        <div class="card">
            <h2>About Me</h2>
            <div class="img_rightColumn">
                <img src="/img/Marina.jpeg" height="250px" width="210px">
            </div>
            <p>My name is Marina Kalinina. I like reading and dancing ang cooking for my family. Future I want to be
                a
                programist.</p>
        </div>

        <div class="card">
            <h2>About blog</h2>
            <img src='/img/bag.jpeg' height="250px" width="210px">
            <p>In this blog I'm studying write code. And I will write posts about programing.</p>
        </div>

        <div class="card">
            <h2>Blog for all!</h2>
            <div class="img">
                <img src='/img/flowers.jpeg' height="250px" width="210px">
            </div>
            <p>ALL people can write posts! .</p>
        </div>

    </div>
</div>
<div class="contact">
    Contact me <br>+375296669286
</div>

<?php $pageContent = ob_get_clean(); ?>

<?php require_once __DIR__.'/../layout.php'; ?>
