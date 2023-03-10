<?php

/**
 * Возвращаем экземпляр приложения app, вызывая фабрику createFromContainer,
 * передаем туда экземпляр контейнера ContainerInterface стандарта psr7
 * включая middleware и маршруты приложения (routes)
 */

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;
use Slim\App;

return static function (ContainerInterface $container): App {
    $app = AppFactory::createFromContainer($container);
    (require __DIR__ . '/../config/middleware.php')($app);
    (require __DIR__ . '/../config/routes.php')($app);
    return $app;
};
