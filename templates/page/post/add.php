<?php /** @var $title string|null */ ?>
<?php /** @var $text string|null */ ?>
<?php /** @var $errors array */ ?>

<?php $pageTitle = 'Add post'; ?>

<?php ob_start(); ?>

<div class="header">
    <a href="/">Blog</a>
</div>
<div class="card">
    <div class="container">
        <h1>Add text</h1>
        <p>Please add text in the blog.</p>
        <hr>
        <form enctype="multipart/form-data" method="post">

            <div class="login">
                <label for="title">Write a headline</label>
            </div>
            <textarea id=title cols="45" rows="8" name="title"><?= htmlspecialchars($title) ?></textarea>

            <div class="password">
                <label for="title">Select image</label>
            </div>
            <div>
                <input name="file" type="file">
            </div>

            <div class="login">
                <label for="text">Write you text</label>
            </div>
            <textarea id="text" name="text" cols="45" rows="10"><?= htmlspecialchars($text) ?></textarea>

            <?php foreach ($errors as $error): ?>
                <div class="registerError"><?= $error ?></div>
            <?php endforeach; ?>

            <input type="submit" class="registerBtn" value="Add">

        </form>
    </div>
</div>

<?php $pageContent = ob_get_clean(); ?>

<?php require_once __DIR__.'/../../layout.php'; ?>
