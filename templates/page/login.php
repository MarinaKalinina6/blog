<?php /** @var $username string|null */ ?>
<?php /** @var $password string|null */ ?>
<?php /** @var $errorMessage string|null */ ?>

<?php $pageTitle = 'login'; ?>

<?php ob_start() ?>

    <div class="header">
        <a href="index.php">Blog</a>
    </div>
    <div class="card">
        <div class="container">
            <h1>Login</h1>
            <p>Please fill in this form to come in an account.</p>
            <hr>

            <form method="POST">
                <div class="login_password">

                    <div class="login">
                        <label for="username">Login:</label>
                    </div>
                    <input type="text" placeholder="Enter Username" name="username" id="username"
                           value="<?= $username ?>">

                    <div class="password">
                        <label for="password">Password:</label>
                    </div>
                    <input type="password" placeholder="Enter Password" name="password" id="password"
                           value="<?= $password ?>">

                    <?php if ($errorMessage !== null): ?>
                        <div class="registerError"> <?= $errorMessage ?> </div>
                    <?php endif; ?>

                    <div class="submit_enter">
                        <button type="submit" class="registerBtn">Login</button>
                    </div>
                </div>

                <div class="container signIn">
                    <p>Dont have an account? <a href="registration.php">Sign in</a></p>
                </div>

            </form>
        </div>
    </div>

<?php $pageContent = ob_get_clean(); ?>

<?php require_once __DIR__.'/../layout.php'; ?>
