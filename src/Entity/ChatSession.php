<?php

namespace App\Entity;

use App\Repository\ChatSessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChatSessionRepository::class)]
#[ORM\Table(name: 'chat_sessions')]
class ChatSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'session', fetch: 'LAZY')]
    #[ORM\JoinColumn(name: 'room_id', referencedColumnName: 'room_id', nullable: true, onDelete: 'SET NULL')]
    private ?Room $room = null;

    /**
     * @var Collection
     */
    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'chatSessions', fetch: 'LAZY')]
    #[ORM\JoinTable(name: 'chat_session_participants')]
    private Collection $participants;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(targetEntity: ChatMessage::class, mappedBy: 'session', cascade: ['persist', 'remove'], fetch: 'EXTRA_LAZY')]
    private Collection $messages;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(enumType: SessionStatus::class)]
    private SessionStatus $status = SessionStatus::IN_PROGRESS;

    public function __construct()
    {
        $this->participants = new ArrayCollection();
        $this->messages = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRoom(): ?Room
    {
        return $this->room;
    }

    public function setRoom(?Room $room): self
    {
        $this->room = $room;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(User $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants->add($participant);
        }
        return $this;
    }

    public function removeParticipant(User $participant): self
    {
        $this->participants->removeElement($participant);
        return $this;
    }

    /**
     * @return Collection
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(ChatMessage $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setSession($this);
        }
        return $this;
    }

    public function removeMessage(ChatMessage $message): self
    {
        if ($this->messages->removeElement($message)) {
            if ($message->getSession() === $this) {
                $message->setSession(null);
            }
        }
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

    public function getStatus(): SessionStatus
    {
        return $this->status;
    }

    public function setStatus(SessionStatus $status): self
    {
        $this->status = $status;
        return $this;
    }
}