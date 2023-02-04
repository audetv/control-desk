<?php

declare(strict_types=1);

use App\Auth;
use App\Auth\Entity\User\User;
use App\Auth\Entity\User\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

return [
    UserRepository::class => static function (ContainerInterface $container): UserRepository {
        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);
        $repo = $em->getRepository(User::class);
        return new UserRepository($em, $repo);
    },
];
