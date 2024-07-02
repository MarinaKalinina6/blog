<?php /** @var $username string|null */ ?>
<?php /** @var $password string|null */ ?>
<?php /** @var $password1 string|null */ ?>
<?php /** @var $errors array */ ?>

<?php $pageTitle = 'Registration'; ?>

<?php ob_start(); ?>

<div class="header">
    <a href="index.php " class="Blog">Blog</a>
</div>

<div class="card">
    <div class="container">
        <h1>Register</h1>
        <p>Please fill in this form to create an account.</p>
        <hr>
        <form method="POST">
            <div class="login_password">
                <div class="login">
                    <label for="username">Login</label>
                </div>
                <input type="text" placeholder="Enter Username" name="username" id="username"
                       value="<?= $username ?>">

                <div class="password">
                    <label for="password">Password </label>
                </div>
                <input type="password" placeholder="Enter Password" name="password" id="password"
                       value="<?= $password ?>">

                <div class="password">
                    <label for="password1">Repeat Password</label>
                </div>
                <input type="password" placeholder="Repeat Password" name="password1" id="password1"
                       value="<?= $password1 ?>">

                <?php foreach ($errors as $error): ?>
                    <div class="registerError"><?= $error ?></div>
                <?php endforeach; ?>

                <button type="submit" class="registerBtn">Registration</button>

        </form>

        <div class="container signIn">
            <p>Already have an account? <a href="login.php">Sign in</a>.</p>
        </div>

    </div>
</div>
</div>

<?php $pageContent = ob_get_clean(); ?>

<?php require_once __DIR__.'/../layout.php'; ?>

