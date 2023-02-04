<?php

declare(strict_types=1);

namespace App\Auth\Test\Unit\Entity\User;

use App\Auth\Entity\User\Network;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class NetworkTest extends TestCase
{
    public function testSuccess(): void
    {
        $network = new Network($name = 'vk', $identity = '12345');

        self::assertEquals($name, $network->getName());
        self::assertEquals($identity, $network->getIdentity());
    }

    public function testEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Network($name = '', $identity = '12345');
    }

    public function testEmptyIdentity(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Network($name = 'vk', $identity = '');
    }

    public function testEqual(): void
    {
        $network = new Network($name = 'vk', $identity = 'vk-1');

        self::assertTrue($network->isEqualTo(new Network($name, 'vk-1')));
        self::assertFalse($network->isEqualTo(new Network($name, 'vk-2')));
        self::assertFalse($network->isEqualTo(new Network('yandex', 'yandex-1')));
    }
}
