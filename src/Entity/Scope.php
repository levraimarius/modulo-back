<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ScopeRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use App\Controller\DeleteScopeByUser;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ScopeRepository::class)]
#[ApiFilter(SearchFilter::class, properties: ['user.id' => 'exact'])]
#[ApiResource]
class Scope
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "scopes")]
    #[Groups(['user:write'])]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Structure::class)]
    #[Groups(['user:write'])]
    private Structure $structure;

    #[ORM\ManyToOne(targetEntity: Role::class)]
    #[Groups(['user:write'])]
    private Role $role;

    #[ORM\Column(type: 'boolean')]
    private bool $active = true;

    #[Pure] public function __construct(Structure $structure, Role $role)
    {
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
    
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
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
