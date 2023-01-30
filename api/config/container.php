<?php

/**
 * Создаем и возвращаем экземпляр билдера контейнера,
 * включаем файл с dependencies в передачу определения для построения контейнера
 */

declare(strict_types=1);

use DI\ContainerBuilder;

$builder = new ContainerBuilder();

$builder->addDefinitions(require __DIR__ . '/dependencies.php');

return $builder->build();
