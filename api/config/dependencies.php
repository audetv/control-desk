<?php

declare(strict_types=1);

$files = glob(__DIR__ . '/common/*.php');

$config = array_map(
    static function($file) {
        return require $file;
    },
    $files
);

return array_merge_recursive(...$config);
