<?php

declare(strict_types=1);

require_once __DIR__.'/../common/database.php';

$connection = database_connect();
$connection->query(' ALTER TABLE posts CHANGE COLUMN `text` `text` VARCHAR(1000) NULL DEFAULT NULL');
