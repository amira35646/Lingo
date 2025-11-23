<?php

namespace App\Entity;

use App\Repository\ProficiencyLevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProficiencyLevelRepository::class)]
#[ORM\Table(name: 'proficiency_level')]
class ProficiencyLevel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 50, nullable: false)]
    private ?string $levelName = null; // beginner, intermediate, advanced

    #[ORM\ManyToOne(targetEntity: Language::class, inversedBy: 'proficiencyLevels')]
    #[ORM\JoinColumn(name: 'language_id', nullable: false)]
    private ?Language $language = null;

    /**
     * @var Collection<int, Room>
     */
    #[ORM\OneToMany(targetEntity: Room::class, mappedBy: 'proficiencyLevel')]
    private Collection $rooms;

    public function __construct()
    {
        $this->rooms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLevelName(): ?string
    {
        return $this->levelName;
    }

    public function setLevelName(string $levelName): static
    {
        $this->levelName = $levelName;
        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): static
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return Collection<int, Room>
     */
    public function getRooms(): Collection
    {
        return $this->rooms;
    }

    public function addRoom(Room $room): static
    {
        if (!$this->rooms->contains($room)) {
            $this->rooms->add($room);
            $room->setProficiencyLevel($this);
        }
        return $this;
    }

    public function removeRoom(Room $room): static
    {
        if ($this->rooms->removeElement($room)) {
            if ($room->getProficiencyLevel() === $this) {
                $room->setProficiencyLevel(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return sprintf('ProficiencyLevel{id=%d, levelName=\'%s\'}', $this->id ?? 0, $this->levelName ?? '');
    }
}