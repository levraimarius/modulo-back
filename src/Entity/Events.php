<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EventsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EventsRepository::class)]
#[ApiResource] 
#[ApiFilter(DateFilter::class, properties: ['startAt'])]
class Events
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime_immutable')]
    #[SerializedName('start')]
    #[Groups("structure")]
    private $startAt;

    #[ORM\Column(type: 'datetime_immutable')]
    #[SerializedName('end')]
    #[Groups("structure")]
    private $endAt;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups("structure")]
    private $title;

    #[ORM\ManyToOne(targetEntity: EventCategory::class, inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("structure")]
    private $category;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\ManyToMany(targetEntity: Role::class, inversedBy: 'events')]
    private $invitedRoles;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'events')]
    private $invitedPersons;

    #[ORM\Column(type: 'boolean')]
    #[Groups("structure")]
    private $isVisible;

    #[ORM\ManyToMany(targetEntity: Structure::class, inversedBy: 'events')]
    private $linkedStructures;

    public function __construct()
    {
        $this->invitedRoles = new ArrayCollection();
        $this->invitedPersons = new ArrayCollection();
        $this->linkedStructures = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartAt(): ?\DateTimeImmutable
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeImmutable $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeImmutable $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCategory(): ?EventCategory
    {
        return $this->category;
    }

    public function setCategory(?EventCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Role>
     */
    public function getInvitedRoles(): Collection
    {
        return $this->invitedRoles;
    }

    public function addInvitedRole(Role $invitedRole): self
    {
        if (!$this->invitedRoles->contains($invitedRole)) {
            $this->invitedRoles[] = $invitedRole;
        }

        return $this;
    }

    public function removeInvitedRole(Role $invitedRole): self
    {
        $this->invitedRoles->removeElement($invitedRole);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getInvitedPersons(): Collection
    {
        return $this->invitedPersons;
    }

    public function addInvitedPerson(User $invitedPerson): self
    {
        if (!$this->invitedPersons->contains($invitedPerson)) {
            $this->invitedPersons[] = $invitedPerson;
        }

        return $this;
    }

    public function removeInvitedPerson(User $invitedPerson): self
    {
        $this->invitedPersons->removeElement($invitedPerson);

        return $this;
    }

    public function getIsVisible(): ?bool
    {
        return $this->isVisible;
    }

    public function setIsVisible(bool $isVisible): self
    {
        $this->isVisible = $isVisible;

        return $this;
    }

    /**
     * @return Collection<int, Structure>
     */
    public function getLinkedStructures(): Collection
    {
        return $this->linkedStructures;
    }

    public function addLinkedStructure(Structure $linkedStructure): self
    {
        if (!$this->linkedStructures->contains($linkedStructure)) {
            $this->linkedStructures[] = $linkedStructure;
        }

        return $this;
    }

    public function removeLinkedStructure(Structure $linkedStructure): self
    {
        $this->linkedStructures->removeElement($linkedStructure);

        return $this;
    }
}
