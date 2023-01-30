<?php

declare(strict_types=1);

use DI\ContainerBuilder;

/**
 * Создаем и возвращаем экземпляр билдера контейнера,
 * включаем файл с dependencies в передачу определения для построения контейнера
 */
$builder = new ContainerBuilder();

$builder->addDefinitions(require __DIR__ . '/dependencies.php');

return $builder->build();
