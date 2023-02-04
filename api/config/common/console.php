<?php

declare(strict_types=1);

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand;
use Doctrine\ORM\Tools\Console\EntityManagerProvider;
use Doctrine\ORM\Tools\Console\EntityManagerProvider\SingleManagerProvider;
use Psr\Container\ContainerInterface;

return [

    EntityManagerProvider::class => static fn(ContainerInterface $container): EntityManagerProvider =>
        /** @psalm-suppress MixedArgument */
    new SingleManagerProvider($container->get(EntityManagerInterface::class)),

    ValidateSchemaCommand::class => static fn(ContainerInterface $container): ValidateSchemaCommand =>
        /** @psalm-suppress MixedArgument */
    new ValidateSchemaCommand($container->get(EntityManagerProvider::class)),

    'config' => [
        'console' => [
            'commands' => [
                ValidateSchemaCommand::class,
            ],
        ],
    ],
];
