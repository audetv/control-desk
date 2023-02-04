<?php

declare(strict_types=1);

use App\Data\Doctrine\FixDefaultSchemaSubscribe;

return [
    'config' => [
        'doctrine' => [
            'dev_mode' => true,
            'cache_dir' => null,
            'proxy_dir' => __DIR__ . '/../../var/cache/' . PHP_SAPI . '/doctrine/proxy',
            'subscribers' => [
                FixDefaultSchemaSubscribe::class,
            ],
        ],
    ],
];
