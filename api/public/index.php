<?php

declare(strict_types=1);

use DI\Container;
use DI\ContainerBuilder;
use App\Http;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\Factory\AppFactory;

http_response_code(500);

require __DIR__ . '/../vendor/autoload.php';

/**
 * Создаем экземпляр билдера контейнера и передаем определения для построения контейнера
 */
$builder = new ContainerBuilder();

$builder->addDefinitions(
    [
        'config' => [
            'debug' => (bool)getenv('APP_DEBUG'),
        ],
        ResponseFactoryInterface::class => DI\get(\Slim\Psr7\Factory\ResponseFactory::class)
    ]);
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
/**
 * Передаем значение параметра displayErrorDetails из контейнера
 */
$app->addErrorMiddleware($container->get('config')['debug'], true, true);

$app->get('/', Http\Action\HomeAction::class);

$app->run();
