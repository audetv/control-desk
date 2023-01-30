<?php

declare(strict_types=1);

use DI\Container;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Factory\AppFactory;

http_response_code(500);

require __DIR__ . '/../vendor/autoload.php';

/**
 * Создаем экземпляр билдера контейнера и передаем определения для построения контейнера
 */
$builder = new DI\ContainerBuilder();
$builder->addDefinitions(require __DIR__ . '/../config/dependencies.php');
/**
 * Создаем экземпляр контейнера с помощью билдера.
 * @var Container $container
 */
$container = $builder->build();

/**
 * Вызываем фабрику createFromContainer и передаем туда экземпляр контейнера
 * ContainerInterface стандарта psr7
 */
$app = AppFactory::createFromContainer($container);

(require __DIR__ . '/../config/middleware.php')($app, $container);
(require __DIR__ . '/../config/routes.php')($app);

$app->run();
