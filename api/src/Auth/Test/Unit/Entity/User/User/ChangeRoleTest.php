<?php

declare(strict_types=1);

namespace App\Auth\Test\Unit\Entity\User\User;

use App\Auth\Entity\User\Role;
use App\Auth\Test\Builder\UserBuilder;
use PHPUnit\Framework\TestCase;

class ChangeRoleTest extends TestCase
{
    public function testSuccess(): void
    {
        $user = (new UserBuilder())->active()->build();

        $user->changeRole($role = new Role(Role::ADMIN));

        self::assertEquals($role, $user->getRole());
    }
}
