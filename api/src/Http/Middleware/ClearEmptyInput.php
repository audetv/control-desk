<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UploadedFileInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ClearEmptyInput implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $request = $request
            ->withParsedBody(self::filterString($request->getParsedBody()))
            ->withUploadedFiles(self::filterFiles($request->getUploadedFiles()));

        return $handler->handle($request);
    }

    /**
     * @param object|array|null $items
     * @return object|array|null
     */
    private static function filterString(object|array|null $items): object|array|null
    {
        if (!is_array($items)) {
            return $items;
        }

        $result = [];

        /**
         * @var string $key
         * @var null|string|object $item
         */
        foreach ($items as $key => $item) {
            if (is_string($item)) {
                $result[$key] = trim($item);
            } else {
                $result[$key] = self::filterString($item);
            }
        }

        return $result;
    }

    private static function filterFiles(array $items): array
    {
        $result = [];

        /**
         * @var string $key
         * @var array|UploadedFileInterface $item
         */
        foreach ($items as $key => $item) {
            if ($item instanceof UploadedFileInterface) {
                if ($item->getError() !== UPLOAD_ERR_NO_FILE) {
                    $result[$key] = $item;
                }
            } else {
                $result[$key] = self::filterFiles($item);
            }
        }

        return $result;
    }
}
