<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\StructureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Annotation\ApiFilter;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: StructureRepository::class)]
#[ApiResource(attributes: ["pagination_client_enabled" => true], normalizationContext: ['groups' => ['structure']])]
#[ApiFilter(SearchFilter::class, properties: ['parentStructure' => 'exact', 'id' => 'exact'])]
class Structure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["structure", "scope"])]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 100)]
    #[Groups(["structure"])]
    private string $name;

    #[ORM\Column(type: 'string', length: 10)]
    #[Groups(["structure"])]
    private string $code;

    #[ORM\ManyToOne(targetEntity: Structure::class)]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(["structure"])]
    private ?Structure $parentStructure = null;

    #[ORM\ManyToMany(targetEntity: Events::class, mappedBy: 'linkedStructures')]
    #[Groups(["structure"])]
    private $events;

    public function __construct(string $name, string $code, ?Structure $parentStructure)
    {
        $this->name = $name;
        $this->code = $code;
        $this->parentStructure = $parentStructure;
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

    public function getParentStructure(): ?Structure
    {
        return $this->parentStructure;
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
            $event->addLinkedStructure($this);
        }

        return $this;
    }

    public function removeEvent(Events $event): self
    {
        if ($this->events->removeElement($event)) {
            $event->removeLinkedStructure($this);
        }

        return $this;
    }
}
