<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\EventCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventCategoryRepository::class)]
#[ApiResource]
class EventCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $label;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\Column(type: 'boolean')]
    private $status;

    #[ORM\ManyToMany(targetEntity: Role::class)]
    private $fonctions;

    #[ORM\ManyToMany(targetEntity: Role::class)]
    #[ORM\JoinTable(name: "event_category_accreditation")]
    private $fonctionAccreditations;

    #[ORM\Column(type: 'boolean')]
    private $defaultValueIsVisible;

    public function __construct()
    {
        $this->fonctions = new ArrayCollection();
        $this->fonctionAccreditations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

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

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Role>
     */
    public function getFonctions(): Collection
    {
        return $this->fonctions;
    }

    public function addFonction(Role $fonction): self
    {
        if (!$this->fonctions->contains($fonction)) {
            $this->fonctions[] = $fonction;
        }

        return $this;
    }

    public function removeFonction(Role $fonction): self
    {
        $this->fonctions->removeElement($fonction);

        return $this;
    }

    /**
     * @return Collection<int, Role>
     */
    public function getFonctionAccreditations(): Collection
    {
        return $this->fonctionAccreditations;
    }

    public function addFonctionAccreditation(Role $fonctionAccreditation): self
    {
        if (!$this->fonctionAccreditations->contains($fonctionAccreditation)) {
            $this->fonctionAccreditations[] = $fonctionAccreditation;
        }

        return $this;
    }

    public function removeFonctionAccreditation(Role $fonctionAccreditation): self
    {
        $this->fonctionAccreditations->removeElement($fonctionAccreditation);

        return $this;
    }

    public function getDefaultValueIsVisible(): ?bool
    {
        return $this->defaultValueIsVisible;
    }

    public function setDefaultValueIsVisible(bool $defaultValueIsVisible): self
    {
        $this->defaultValueIsVisible = $defaultValueIsVisible;

        return $this;
    }
}
