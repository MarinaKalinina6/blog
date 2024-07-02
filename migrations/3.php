<?php

declare(strict_types=1);

require_once __DIR__.'/../common/database.php';

$connection = database_connect();
$connection->query(' ALTER TABLE posts DROP COLUMN image ');