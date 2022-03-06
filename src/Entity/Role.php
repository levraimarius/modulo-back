<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
#[ApiResource]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: AgeSection::class)]
    private Collection $ageSections;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $icon;

    #[Pure] public function __construct()
    {
        $this->ageSections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, AgeSection>
     */
    public function getAgeSections(): Collection
    {
        return $this->ageSections;
    }

    public function addAgeSection(AgeSection $ageSection): self
    {
        if (!$this->ageSections->contains($ageSection)) {
            $this->ageSections[] = $ageSection;
        }

        return $this;
    }

    public function removeAgeSection(AgeSection $ageSection): self
    {
        $this->ageSections->removeElement($ageSection);

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
}
