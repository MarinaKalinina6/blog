<?php /** @var $post Post */ ?>
<?php /** @var $isCanManagePost bool */ ?>

<?php ob_start(); ?>

<div class="header"><a href="/">Blog</a></div>

<div class="card">
    <div class="title">
        <?= htmlspecialchars($post->getTitle()); ?>
    </div>

    <div class="post">
        <div class="text"><?= htmlspecialchars($post->getText()); ?></div>
        <div class="img">
            <img src="/uploads/<?= $post->getId() ?>" width="300px">
        </div>
    </div>

    <div class="author">Author: <?= $post->getAuthorName() ?? 'deleted user' ?></div>
</div>

<?php if ($isCanManagePost === true): ?>
    <div class="edit"><a href="/post_edit.php?id=<?= $post->getId(); ?>">Edit post</a></div>
    <div class="delete"><a href="/post_delete.php?id=<?= $post->getId(); ?>">Delete post</a></div>
<?php endif; ?>

<?php $pageContent = ob_get_clean(); ?>

<?php require_once __DIR__.'/../../layout.php'; ?>
