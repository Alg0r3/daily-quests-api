<?php

namespace App\Factory;

use App\Entity\ApiUser;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<ApiUser>
 */
final class ApiUserFactory extends PersistentProxyObjectFactory
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasherInterface,
    ) {
        parent::__construct();
    }

    public static function class(): string
    {
        return ApiUser::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'userIdentifier' => $this->getDefaultUserIdentifier(),
            'password' => self::faker()->text(),
        ];
    }

    protected function initialize(): static
    {
        return $this->afterInstantiate(function (ApiUser $apiUser) {
            $apiUser->setPassword($this->passwordHasherInterface->hashPassword($apiUser, $apiUser->getPassword()));
        });
    }

    private function getDefaultUserIdentifier(): string
    {
        $randomNumber = self::faker()->numberBetween(100, 999);
        $randomDomainWord = self::faker()->domainWord();

        return "$randomDomainWord$randomNumber.alg0r3";
    }
}
