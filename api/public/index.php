<?php

declare(strict_types=1);

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Factory\AppFactory;


http_response_code(500);

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->get('/', function (ServerRequestInterface $request, ResponseInterface $response, $args) {
    $response->getBody()->write('{}');
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
