<?php

namespace App\Entity;

use App\Enum\RoomStatus;
use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $room_id = null;

    #[ORM\Column]
    private ?int $maxParticipants = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $scheduledTime = null;

    #[ORM\Column]
    private ?int $durationMinutes = null;

    #[ORM\Column(length: 255)]
    private ?string $createdBy = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(enumType: RoomStatus::class)]
    private ?RoomStatus $room_status = RoomStatus::AVAILABLE;

    /**
     * @var Collection<int, User>
     */
    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'rooms')]
    private Collection $users;





    public function __construct()
    {
        $this->users = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->room_id;
    }

    public function getRoomId(): ?int
    {
        return $this->room_id;
    }

    public function setRoomId(int $room_id): static
    {
        $this->room_id = $room_id;

        return $this;
    }

    public function getMaxParticipants(): ?int
    {
        return $this->maxParticipants;
    }

    public function setMaxParticipants(int $maxParticipants): static
    {
        $this->maxParticipants = $maxParticipants;

        return $this;
    }

    public function getScheduledTime(): ?\DateTime
    {
        return $this->scheduledTime;
    }

    public function setScheduledTime(\DateTime $scheduledTime): static
    {
        $this->scheduledTime = $scheduledTime;

        return $this;
    }

    public function getDurationMinutes(): ?int
    {
        return $this->durationMinutes;
    }

    public function setDurationMinutes(int $durationMinutes): static
    {
        $this->durationMinutes = $durationMinutes;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(string $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
    public function getStatus(): ?RoomStatus
    {
        return $this->room_status;  // ✅ Changed from $this->status
    }

    public function setStatus(RoomStatus $status): static
    {
        $this->room_status = $status;  // ✅ Changed from $this->status
        return $this;
    }
// Also add this getter if missing:
    public function getRoomStatus(): ?RoomStatus
    {
        return $this->room_status;
    }


    public function setRoomStatus(RoomStatus $room_status): static
    {
        $this->room_status = $room_status;
        return $this;
    }
    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addRoom($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeRoom($this);
        }

        return $this;
    }
}
