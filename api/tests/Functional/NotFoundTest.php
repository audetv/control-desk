<?php

declare(strict_types=1);

namespace Test\Functional;

use Fig\Http\Message\RequestMethodInterface;
use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;

class NotFoundTest extends WebTestCase
{
    public function testNotFound(): void
    {
        $response = $this->app()->handle(self::json(RequestMethodInterface::METHOD_GET, '/not-found'));
        self::assertEquals(404, $response->getStatusCode());
        self::assertJson($body = (string)$response->getBody());

        $data = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

        self::assertArraySubset([
           'message' => '404 Not Found',
       ], $data);
    }
}
