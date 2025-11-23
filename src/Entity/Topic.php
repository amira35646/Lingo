<?php

namespace App\Entity;

use App\Repository\TopicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TopicRepository::class)]
class Topic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $topic_name = null;

    /**
     * @var Collection<int, Room>
     */

    #[ORM\OneToMany(targetEntity: Room::class, mappedBy: 'topic', fetch: 'LAZY')]
    private Collection $rooms;

    public function __construct()
    {
        $this->rooms = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTopicId(): ?int
    {
        return $this->id;
    }

    public function setTopicId(int $topic_id): static
    {
        $this->topic_id = $topic_id;

        return $this;
    }

    public function getTopicName(): ?string
    {
        return $this->topic_name;
    }

    public function setTopicName(string $topic_name): static
    {
        $this->topic_name = $topic_name;

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
            $room->setTopicRef($this);
        }

        return $this;
    }

    public function removeRoom(Room $room): static
    {
        if ($this->rooms->removeElement($room)) {
            // set the owning side to null (unless already changed)
            if ($room->getTopicRef() === $this) {
                $room->setTopicRef(null);
            }
        }

        return $this;
    }
}
