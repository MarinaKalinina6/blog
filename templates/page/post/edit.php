<?php /** @var $title string */ ?>
<?php /** @var $text string */ ?>
<?php /** @var $id int */ ?>
<?php /** @var $errors array */ ?>
<?php /** @var $post Post */ ?>

<?php $pageTitle = $title; ?>

<?php ob_start(); ?>

<div class="header">
    <a href="/">Blog</a>
</div>
<div class="card">
    <div class="container">
        <form enctype="multipart/form-data" method="post">
            <h1>Edit text</h1>
            <p>Please edit text in the blog.</p>
            <hr>

            <div class="login">
                <h3> Title </h3>
            </div>
            <textarea name="title" cols="45" rows="8"><?= htmlspecialchars($title) ?></textarea>

            <div class="login">
                <h3> Image </h3>
            </div>
            <img src="/uploads/<?= $post->getId() ?>" width="250px">
            <div class="login">
                <input name="file" type="file">
            </div>

            <div class="login">
                <h3>Text</h3>
            </div>
            <textarea name="text" cols="45" rows="10"><?= htmlspecialchars($text) ?></textarea>

            <input type="hidden" value="<?= $id ?>">

            <?php foreach ($errors as $error): ?>
                <div class="registerError"><?= $error ?></div>
            <?php endforeach; ?>

            <div>
                <input type="submit" class="registerBtn">
            </div>

        </form>
    </div>
</div>

<?php $pageContent = ob_get_clean(); ?>

<?php require_once __DIR__.'/../../layout.php'; ?>
