<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

/**
 * Represent a user of this API, mostly another application.
 */
#[Entity]
class ApiUser implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Id]
    #[Column(type: UuidType::NAME, unique: true)]
    private Uuid $id;

    #[Column(type: Types::STRING, unique: true)]
    private string $userIdentifier;

    #[Column(type: Types::STRING)]
    private string $password;

    #[Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    #[Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $updatedAt;

    public function __construct()
    {
        $this->id = Uuid::v7();
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = null;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): ApiUser
    {
        $this->id = $id;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    public function setUserIdentifier(string $userIdentifier): ApiUser
    {
        $this->userIdentifier = $userIdentifier;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): ApiUser
    {
        $this->password = $password;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): ApiUser
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): ApiUser
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getRoles(): array
    {
        return ['ROLE_USER'];
    }

    public function eraseCredentials(): void
    {
        // For any temporary, sensitive data on the user, clear it here
    }
}
