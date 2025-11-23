<?php

namespace App\Entity;

use App\Enum\RoomStatus;
use App\Repository\RoomRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoomRepository::class)]
#[ORM\Table(name: 'chat_rooms')]
class Room
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'room_id',type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Topic::class, fetch: 'LAZY', inversedBy: 'rooms')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Topic $topic = null;

    #[ORM\ManyToOne(targetEntity: Language::class, fetch: 'LAZY', inversedBy: 'rooms')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Language $targetLanguage = null;

    #[ORM\ManyToOne(targetEntity: ProficiencyLevel::class, fetch: 'LAZY', inversedBy: 'rooms')]
    #[ORM\JoinColumn(nullable: true)]
    private ?ProficiencyLevel $proficiencyLevel = null;

    #[ORM\OneToOne(targetEntity: ChatSession::class, mappedBy: 'room', cascade: ['persist', 'remove'], fetch: 'LAZY')]
    private ?ChatSession $session = null;

    /**
     * @var Collection
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'joinedRooms', fetch: 'EXTRA_LAZY')]
    #[ORM\JoinTable(name: 'room_participants')]
    private Collection $participants;

    /**
     * @var Collection
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'readyRooms', fetch: 'EXTRA_LAZY')]
    #[ORM\JoinTable(name: 'room_ready_users')]
    private Collection $readyUsers;

    #[ORM\Column(type: Types::INTEGER)]
    private int $maxParticipants = 5;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private ?\DateTimeInterface $scheduledTime = null;

    #[ORM\Column(type: Types::INTEGER)]
    private int $durationMinutes = 30;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    private ?string $createdBy = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(name: 'room_status', enumType: RoomStatus::class)]
    private ?RoomStatus $room_status = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->room_status = RoomStatus::AVAILABLE;
        $this->participants = new ArrayCollection();
        $this->readyUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoomId(): ?int
    {
        return $this->id;
    }

    public function getTopic(): ?Topic
    {
        return $this->topic;
    }

    public function setTopic(?Topic $topic): self  // FIXED: was ?string
    {
        $this->topic = $topic;
        return $this;
    }

    public function getTargetLanguage(): ?Language
    {
        return $this->targetLanguage;
    }

    public function setTargetLanguage(?Language $targetLanguage): self
    {
        $this->targetLanguage = $targetLanguage;
        return $this;
    }

    public function getProficiencyLevel(): ?ProficiencyLevel
    {
        return $this->proficiencyLevel;
    }

    public function setProficiencyLevel(?ProficiencyLevel $proficiencyLevel): self
    {
        $this->proficiencyLevel = $proficiencyLevel;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(User $user): self
    {
        if (!$this->participants->contains($user)) {
            $this->participants->add($user);
        }
        return $this;
    }

    public function removeParticipant(User $user): self
    {
        $this->participants->removeElement($user);
        return $this;
    }

    /**
     * @return Collection
     */
    public function getReadyUsers(): Collection
    {
        return $this->readyUsers;
    }

    public function addReadyUser(User $user): self
    {
        if (!$this->readyUsers->contains($user)) {
            $this->readyUsers->add($user);
        }
        return $this;
    }

    public function removeReadyUser(User $user): self
    {
        $this->readyUsers->removeElement($user);
        return $this;
    }

    public function getMaxParticipants(): int
    {
        return $this->maxParticipants;
    }

    public function setMaxParticipants(int $maxParticipants): self
    {
        $this->maxParticipants = $maxParticipants;
        return $this;
    }

    public function getScheduledTime(): ?\DateTimeInterface
    {
        return $this->scheduledTime;
    }

    public function setScheduledTime(\DateTimeInterface $scheduledTime): self
    {
        $this->scheduledTime = $scheduledTime;
        return $this;
    }

    public function getDurationMinutes(): int
    {
        return $this->durationMinutes;
    }

    public function setDurationMinutes(int $durationMinutes): self
    {
        $this->durationMinutes = $durationMinutes;
        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?string $createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getRoomStatus(): ?RoomStatus
    {
        return $this->room_status;
    }

    public function setRoomStatus(?RoomStatus $status): self
    {
        $this->room_status = $status;
        return $this;
    }

    public function getSession(): ?ChatSession
    {
        return $this->session;
    }

    public function setSession(?ChatSession $session): self
    {
        if ($session === null && $this->session !== null) {
            $this->session->setRoom(null);
        }
        if ($session !== null && $session->getRoom() !== $this) {
            $session->setRoom($this);
        }
        $this->session = $session;
        return $this;
    }
}