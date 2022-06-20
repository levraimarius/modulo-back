<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Symfony\Component\Serializer\Annotation\Groups;

#[UniqueEntity(fields: ['uuid'], message: 'Un compte est déjà lié à ce numéro d\'adhérent')]
#[UniqueEntity(fields: ['email'], message: 'Un compte est déjà lié à cette adresse mail')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource(attributes: ["pagination_items_per_page" => 10, "pagination_client_enabled" => true, "force_eager" => false], denormalizationContext: ['groups' => ['user:write'], "enable_max_depth" => true], normalizationContext: ['groups' => ['user', 'scope'], "enable_max_depth" => true])]
#[ApiFilter(SearchFilter::class, properties: ['lastName' => 'partial', 'uuid' => 'exact'])]
#[ApiFilter(OrderFilter::class, properties: ['id' => 'DESC'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['structure', 'user'])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 96, unique: true)]
    #[Groups(['user:write', 'user'])]
    private string $uuid;

    #[ORM\Column(type: 'string', length: 200, unique: true)]
    #[Groups(['user:write', 'user'])]
    private string $email;

    #[ORM\Column(type: 'json')]
    #[Groups(['user:write', 'user'])]
    private array $roles = [];

    #[ORM\Column(type: 'string')]
    #[Groups(['user:write', 'user'])]
    private string $password;

    #[ORM\Column(type: 'string')]
    #[Groups(['user:write', 'user'])]
    private string $firstName;

    #[ORM\Column(type: 'string')]
    #[Groups(['user:write', 'user'])]
    private string $lastName;

    #[ORM\Column(type: 'string', length: 1)]
    #[Groups(['user:write', 'user'])]
    private string $genre;

    #[Groups(['user:write', 'scope', 'user'])]
    #[ORM\OneToMany(targetEntity: Scope::class, mappedBy: "user", orphanRemoval: true, cascade: ["persist"])]
    private $scope;

    #[ORM\ManyToMany(targetEntity: Events::class, mappedBy: 'invitedPersons')]
    #[Groups(['user:write'])]
    private $events;

    public function __construct(string $uuid, string $email, string $firstName, string $lastName, string $genre)
    {
        $this->uuid = $uuid;
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->genre = $genre;
        $this->scope = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->uuid;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): User
    {
        $this->genre = $genre;

        return $this;
    }

    public function getFullName(): string
    {
        return trim(sprintf('%s %s', $this->getFirstName(), $this->getLastName()));
    }

    public function eraseCredentials()
    {
    }

    /**
     * @return Collection<int, Scope>
     */
    public function getScope(): Collection
    {
        return $this->scope;
    }

    public function addScope(Scope $sc): self
    {
        if (!$this->scope->contains($sc)) {
            $this->scope[] = $sc;
            $sc->setUser($this);
        }

        return $this;
    }

    public function removeScope(Scope $sc): self
    {
        if ($this->scope->removeScope($sc)) {
            // set the owning side to null (unless already changed)
            if ($sc->getUser() === $this) {
                $sc->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Events>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Events $event): self
    {
        if (!$this->events->contains($event)) {
            $this->events[] = $event;
            $event->addInvitedPerson($this);
        }

        return $this;
    }

    public function removeEvent(Events $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeInvitedPerson($this);
        }

        return $this;
    }
}
