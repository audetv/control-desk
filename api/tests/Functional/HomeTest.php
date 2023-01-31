<?php

declare(strict_types=1);

namespace Test\Functional;

use Fig\Http\Message\RequestMethodInterface;

/**
 * @coversNothing
 */
class HomeTest extends WebTestCase
{
    public function testMethod(): void
    {
        $response = $this->app()->handle(self::json(RequestMethodInterface::METHOD_POST, '/'));
        self::assertEquals(405, $response->getStatusCode());
    }

    public function testSuccess(): void
    {
        $response = $this->app()->handle(self::json('GET', '/'));

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('{}', (string)$response->getBody());
    }
}
