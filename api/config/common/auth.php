<?php

declare(strict_types=1);

use App\Auth;
use App\Auth\Entity\User\User;
use App\Auth\Entity\User\UserRepository;
use App\Auth\Service\JoinConfirmationSender;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Container\ContainerInterface;

return [
    UserRepository::class => static function (ContainerInterface $container): UserRepository {
        $em = $container->get(EntityManagerInterface::class);
        $repo = $em->getRepository(User::class);
        return new UserRepository($em, $repo);
    },
    JoinConfirmationSender::class => function (ContainerInterface $container): JoinConfirmationSender {
        $mailer = $container->get(Swift_Mailer::class);
        /**
         * @psalm-suppress MixedArrayAccess
         * @psalm-var array{url:string} $frontendConfig
         */
        $frontendConfig = $container->get('config')['frontend'];

        return new JoinConfirmationSender($mailer, $frontendConfig['url']);
    },
];
