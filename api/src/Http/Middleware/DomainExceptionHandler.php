<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use DomainException;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class DomainExceptionHandler implements MiddlewareInterface
{
    private LoggerInterface $logger;
    private TranslatorInterface $translator;
    private ResponseFactoryInterface $factory;

    public function __construct(
        LoggerInterface $logger,
        TranslatorInterface $translator,
        ResponseFactoryInterface $factory
    ) {
        $this->logger = $logger;
        $this->translator = $translator;
        $this->factory = $factory;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (DomainException $exception) {
            $this->logger->warning($exception->getMessage(), [
                'exception' => $exception,
                'url' => (string)$request->getUri(),
            ]);
            $response = $this->factory->createResponse(409)
                ->withHeader('Content-Type', 'application/json');

            $response->getBody()->write(json_encode([
                'message' => $this->translator->trans($exception->getMessage(), [], 'exceptions')
            ], JSON_THROW_ON_ERROR, 512));

            return $response;
        }
    }
}
