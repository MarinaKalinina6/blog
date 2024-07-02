<?php

declare(strict_types=1);

require_once __DIR__.'/common/session.php';
require_once __DIR__.'/common/request.php';

if (get_user() !== null) {
    header('Location: /');
    exit;
}

$username = post_get_string('username');
$password = post_get_string('password');
$password1 = post_get_string('password1');
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($username === '' && $password === '' && $password1 === '') {
        $errors[] = 'Please, enter credentials';
    } else {
        if ($username === '') {
            $errors[] = 'Please, enter username';
        }
        if ($password === '') {
            $errors[] = 'Please, enter password';
        }
        if ($password !== '' && $password1 === '') {
            $errors[] = 'Please, enter password confirm';
        }
    }
    if ($errors === [] && $password !== $password1) {
        $errors[] = 'passwords don\'t match';
    }

    /** @var UserRepository $userRepository */
    $userRepository = require_once __DIR__.'/src/Repository/UserRepository.php';

    if ($errors === []) {
        $isUsernameTaken = $userRepository->getByUsername($username);

        if ($isUsernameTaken === false) {
            $userRepository->insert($username, $password);
            $_SESSION['user_id'] = $userRepository->lastInsertId();
            header('Location: /');
        } else {
            $errors[] = 'Пользователь с таким логином существует';
        }
    }
}
require_once __DIR__.'/templates/page/registration.php';
