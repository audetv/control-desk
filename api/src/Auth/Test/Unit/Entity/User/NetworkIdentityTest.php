<?php

declare(strict_types=1);

namespace App\Auth\Test\Unit\Entity\User;

use App\Auth\Entity\User\NetworkIdentity;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class NetworkIdentityTest extends TestCase
{
    public function testSuccess(): void
    {
        $network = new NetworkIdentity($name = 'vk', $identity = '12345');

        self::assertEquals($name, $network->getNetwork());
        self::assertEquals($identity, $network->getIdentity());
    }

    public function testEmptyName(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new NetworkIdentity($name = '', $identity = '12345');
    }

    public function testEmptyIdentity(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new NetworkIdentity($name = 'vk', $identity = '');
    }

    public function testEqual(): void
    {
        $network = new NetworkIdentity($name = 'vk', $identity = 'vk-1');

        self::assertTrue($network->isEqualTo(new NetworkIdentity($name, 'vk-1')));
        self::assertFalse($network->isEqualTo(new NetworkIdentity($name, 'vk-2')));
        self::assertFalse($network->isEqualTo(new NetworkIdentity('yandex', 'yandex-1')));
    }
}
