<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use DateTime;


#[ORM\Table(name: 'users')]
#[ORM\Index(name: 'u_email', columns: ['email'])]
#[ORM\Index(name: 'u_status', columns: ['status'])]
#[ORM\Index(name: 'u_created_at', columns: ['created_at'])]
#[ORM\Index(name: 'u_updated_at', columns: ['updated_at'])]
#[ORM\Entity(repositoryClass: \App\Repository\UserRepository::class)]
#[UniqueEntity(fields: ['email'], errorPath: 'email', message: 'Este Email ya está en uso')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, SoftDeleteableInterface
{

    final public const ROLE_USER = 'ROLE_USER';
    final public const ROLE_ADMIN = 'ROLE_ADMIN';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var array
     * @ORM\Column(type="json", nullable=false)
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(type: 'string', length: 50, nullable: false)]
    private string $status = self::STATUS_PENDING;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private string|null|int $token = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?DateTime $requested_token;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $createdAt = null;

    #[ORM\Column(type: 'datetime')]
    private ?DateTime $updatedAt = null;



    public function __construct(#[ORM\Column(type: 'string', length: 255, nullable: false, unique: false)]
                                private string $email)
    {
        $this->createdAt = $this->updatedAt = new DateTime();
        $this->updatetoken();
        $this->requested_token=new DateTime();
        $this->roles = [self::ROLE_USER];

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getToken(): int|string|null
    {
        return $this->token;
    }

    public function setToken(int|string|null $token): void
    {
        $this->token = $token;
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = self::ROLE_USER;
        return array_unique($roles);
    }

    public function getRequestedToken(): ? DateTime
    {
        return $this->requested_token;
    }

    public function setRequestedToken(DateTime $requestedToken): self
    {
        $this->requested_token = $requestedToken;
        return $this;
    }


    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        if ($this->roles !== $roles) {
            $this->roles = $roles;
        }

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function setAsDeleted(): void
    {
        $this->status = self::STATUS_DELETED;
    }

    public function isDeleted(): bool
    {
        return self::STATUS_DELETED === $this->status;
    }

    public function setAsActive(): void
    {
        $this->status = self::STATUS_ACTIVE;
    }

    public function setAsPending(): void
    {
        $this->status = self::STATUS_PENDING;
    }


    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    public function isActive(): bool
    {
        return $this->status === self::STATUS_ACTIVE;
    }


    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    public function updateToken(){
        $this->token=random_int(10000,99999);
    }

    public function cleanToken():void
    {
        $this->token=null;
        $this->requested_token=null;


    }

}
