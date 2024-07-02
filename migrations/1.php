<?php

declare(strict_types=1);

require_once __DIR__.'/../common/database.php';

$connection = database_connect();
$connection->query(' CREATE TABLE users (id INT NOT NULL AUTO_INCREMENT  PRIMARY KEY, username VARCHAR(20), password VARCHAR(20))');