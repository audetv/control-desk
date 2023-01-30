<?php

declare(strict_types=1);

use DI\ContainerBuilder;

/**
 * Создаем экземпляр билдера контейнера и передаем определения для построения контейнера
 */
$builder = new ContainerBuilder();

$builder->addDefinitions(require __DIR__ . '/dependencies.php');

return $builder->build();
