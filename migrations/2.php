<?php

declare(strict_types=1);

require_once __DIR__.'/../common/database.php';

$connection = database_connect();

$connection->query(
    'CREATE TABLE posts(id INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,user_id INT ,title VARCHAR(255), image VARCHAR(200),text VARCHAR(255), added_at DATETIME)'
);
