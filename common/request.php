<?php

declare(strict_types=1);

function query_get_positive_int(string $key): ?int
{
    if (array_key_exists($key, $_GET) === false) {
        return null;
    }

    $value = $_GET[$key];

    if (is_numeric($value) === false) {
        return null;
    }

    $value = (int)$value;

    if ($value < 1) {
        $value = 1;
    }

    return $value;
}

function post_get_string($key): ?string
{
    if (array_key_exists($key, $_POST) === false) {
        return null;
    }

    $value = $_POST[$key];

    if (is_string($value) === false) {
        return null;
    }

    return $value;
}
