<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ScopeRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use App\Controller\DeleteScopeByUser;

#[ORM\Entity(repositoryClass: ScopeRepository::class)]
#[ApiResource(itemOperations: [
    'get',
    'put',
    'patch',
    'delete',
    'delete_by_user' => [
        'method' => 'DELETE',
        'path' => '/scopes/user/{id}',
        'controller' => DeleteScopeByUser::class
    ],
])]
class Scope
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Structure::class)]
    private Structure $structure;

    #[ORM\ManyToOne(targetEntity: Role::class)]
    private Role $role;

    #[ORM\Column(type: 'boolean')]
    private bool $active = true;

    #[Pure] public function __construct(User $user, Structure $structure, Role $role)
    {
        $this->user = $user;
        $this->structure = $structure;
        $this->role = $role;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getStructure(): Structure
    {
        return $this->structure;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function isActive(): bool
    {
        return $this->active;
    }
}
