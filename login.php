<?php

declare(strict_types=1);

require_once __DIR__.'/common/database.php';
require_once __DIR__.'/common/session.php';
require_once __DIR__.'/common/request.php';

if (get_user() !== null) {
    header('Location: /');
    exit;
}

$username = post_get_string('username');
$password = post_get_string('password');
$errorMessage = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($username === '') {
        $errorMessage = 'Enter login';
    }
    if ($password === '') {
        $errorMessage = 'Enter password';
    }
    if ($username === '' && $password === '') {
        $errorMessage = 'Enter login and password';
    }

    if ($errorMessage === null) {

        /** @var UserRepository $userRepository */
        $userRepository = require_once __DIR__.'/src/Repository/UserRepository.php';
        $user = $userRepository->getByUsername($username);

        if ($user === false || $password !== $user->getPassword()) {
            $errorMessage = 'This user not found';
        } else {
            $_SESSION['user_id'] = $user->getId();
            header('Location: /');
        }
    }
}
require_once __DIR__.'/templates/page/login.php';