<?php

declare(strict_types=1);

namespace Test\Functional;

use Fig\Http\Message\RequestMethodInterface;

class NotFoundTest extends WebTestCase
{
    public function testNotFound(): void
    {
        $response = $this->app()->handle(self::json(RequestMethodInterface::METHOD_GET, '/not-found'));
        self::assertEquals(404, $response->getStatusCode());
    }
}
