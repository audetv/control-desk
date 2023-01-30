<?php

declare(strict_types=1);

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;


http_response_code(500);

require __DIR__ . '/../vendor/autoload.php';

/**
 * Создаем экземпляр контейнера
 */
$container = new Container();

/**
 * Вызываем фабрику createFromContainer и передаем туда экземпляр контейнера
 * ContainerInterface стандарта psr7
 */
$app = AppFactory::createFromContainer($container);

$app->addErrorMiddleware((bool)getenv('APP_DEBUG'), true, true);

$app->get('/', function (Request $request, Response $response, $args) {
    throw new \Slim\Exception\HttpNotFoundException($request);
    $response->getBody()->write('{}');
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
