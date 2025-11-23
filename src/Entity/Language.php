<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
#[ORM\Table(name: 'language')]
class Language
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 100, unique: true, nullable: false)]
    private ?string $name = null; // English, Spanish, etc.

    /**
     * @var Collection<int, ProficiencyLevel>
     */
    #[ORM\OneToMany(
        targetEntity: ProficiencyLevel::class,
        mappedBy: 'language',
        cascade: ['persist', 'remove'],
        fetch: 'EAGER',
        orphanRemoval: true
    )]
    private Collection $proficiencyLevels;

    /**
     * @var Collection<int, Room>
     */
    #[ORM\OneToMany(targetEntity: Room::class, mappedBy: 'targetLanguage')]
    private Collection $rooms;

    public function __construct()
    {
        $this->proficiencyLevels = new ArrayCollection();
        $this->rooms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Collection<int, ProficiencyLevel>
     */
    public function getProficiencyLevels(): Collection
    {
        return $this->proficiencyLevels;
    }

    public function addProficiencyLevel(ProficiencyLevel $proficiencyLevel): static
    {
        if (!$this->proficiencyLevels->contains($proficiencyLevel)) {
            $this->proficiencyLevels->add($proficiencyLevel);
            $proficiencyLevel->setLanguage($this);
        }
        return $this;
    }

    public function removeProficiencyLevel(ProficiencyLevel $proficiencyLevel): static
    {
        if ($this->proficiencyLevels->removeElement($proficiencyLevel)) {
            // Set the owning side to null (unless already changed)
            if ($proficiencyLevel->getLanguage() === $this) {
                $proficiencyLevel->setLanguage(null);
            }
        }
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
            $room->setTargetLanguage($this);
        }
        return $this;
    }

    public function removeRoom(Room $room): static
    {
        if ($this->rooms->removeElement($room)) {
            if ($room->getTargetLanguage() === $this) {
                $room->setTargetLanguage(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return sprintf('Language{id=%d, name=\'%s\'}', $this->id ?? 0, $this->name ?? '');
    }
}