<?php

/**
 * Returns currently authorized user.
 */
function get_user(): ?User
{
    session_start();

    $userId = $_SESSION['user_id'] ?? null;

    if ($userId === null) {
        return null;
    }

    /** @var UserRepository $userRepository */
    $userRepository = require_once __DIR__.'/../src/Repository/UserRepository.php';

    return $userRepository->getById($userId);
}
