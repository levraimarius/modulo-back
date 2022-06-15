<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
#[ApiResource(attributes: ["pagination_client_enabled" => true])]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("structure")]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100)]
    private string $name;

    #[ORM\Column(type: 'string', length: 10)]
    private string $code;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $feminineName = null;

    #[ORM\ManyToOne(targetEntity: AgeSection::class)]
    private AgeSection $ageSection;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $icon;

    #[ORM\ManyToMany(targetEntity: Accreditation::class)]
    private $accreditations;

    #[ORM\ManyToMany(targetEntity: Events::class, mappedBy: 'invitedRoles')]
    private $events;

    #[Pure] public function __construct(string $name, string $code, AgeSection $ageSection, ?string $feminineName = null)
    {
        $this->name = $name;
        $this->code = $code;
        $this->feminineName = $feminineName;
        $this->ageSection = $ageSection;
        $this->accreditations = new ArrayCollection();
        $this->events = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getFeminineName(): ?string
    {
        return $this->feminineName;
    }

    public function setFeminineName(?string $feminineName): self
    {
        $this->feminineName = $feminineName;

        return $this;
    }

    public function getAgeSection(): AgeSection
    {
        return $this->ageSection;
    }

    public function setAgeSection(AgeSection $ageSection): self
    {
        $this->ageSection = $ageSection;

        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(?string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return Collection<int, Accreditation>
     */
    public function getAccreditations(): Collection
    {
        return $this->accreditations;
    }

    public function addAccreditation(Accreditation $accreditation): self
    {
        if (!$this->accreditations->contains($accreditation)) {
            $this->accreditations[] = $accreditation;
        }

        return $this;
    }

    public function removeAccreditation(Accreditation $accreditation): self
    {
        $this->accreditations->removeElement($accreditation);

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
            $event->addInvitedRole($this);
        }

        return $this;
    }

    public function removeEvent(Events $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeInvitedRole($this);
        }

        return $this;
    }
}
