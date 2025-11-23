<?php

namespace App\Entity;

use App\Repository\ChatMessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChatMessageRepository::class)]
#[ORM\Table(name: 'message')]
class ChatMessage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::INTEGER)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: ChatSession::class, inversedBy: 'messages')]
    #[ORM\JoinColumn(name: 'session_id', nullable: true)]
    private ?ChatSession $session = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?int $senderId = null;

    #[ORM\Column(length: 50)]
    private ?string $senderType = null; // "learner" or "AI"

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $timestamp = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $correctionsJson = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $senderName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $correction = null; // For AI corrections

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $translation = null; // For AI translations

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $tip = null; // Optional learning tip

    // Optional fields for analytics
    #[ORM\Column(type: Types::BOOLEAN, options: ['default' => false])]
    private bool $isCorrect = false; // True if the sentence was correct

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $mistakeType = null; // e.g. "Grammar", "Preposition"

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSession(): ?ChatSession
    {
        return $this->session;
    }

    public function setSession(?ChatSession $session): static
    {
        $this->session = $session;
        return $this;
    }

    // Helper method to get session ID without loading the whole session
    public function getSessionId(): ?int
    {
        return $this->session?->getId();
    }

    public function getSenderId(): ?int
    {
        return $this->senderId;
    }

    public function setSenderId(int $senderId): static
    {
        $this->senderId = $senderId;
        return $this;
    }

    public function getSenderType(): ?string
    {
        return $this->senderType;
    }

    public function setSenderType(string $senderType): static
    {
        $this->senderType = $senderType;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }

    public function getTimestamp(): ?\DateTimeInterface
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTimeInterface $timestamp): static
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    public function getCorrectionsJson(): ?string
    {
        return $this->correctionsJson;
    }

    public function setCorrectionsJson(?string $correctionsJson): static
    {
        $this->correctionsJson = $correctionsJson;
        return $this;
    }

    public function getSenderName(): ?string
    {
        // Return cached name if available
        if ($this->senderName !== null) {
            return $this->senderName;
        }

        // Don't trigger lazy loading - return a default
        // The name should be set when creating the message
        return 'Unknown';
    }

// Add a new method to set sender name from User object
    public function setSenderNameFromUser(User $user): self
    {
        $this->senderName = $user->getUsername();
        $this->senderId = $user->getId();
        return $this;
    }

    public function getCorrection(): ?string
    {
        return $this->correction;
    }

    public function setCorrection(?string $correction): static
    {
        $this->correction = $correction;
        return $this;
    }

    public function getTranslation(): ?string
    {
        return $this->translation;
    }

    public function setTranslation(?string $translation): static
    {
        $this->translation = $translation;
        return $this;
    }

    public function getTip(): ?string
    {
        return $this->tip;
    }

    public function setTip(?string $tip): static
    {
        $this->tip = $tip;
        return $this;
    }

    public function isCorrect(): bool
    {
        return $this->isCorrect;
    }

    public function setIsCorrect(bool $isCorrect): static
    {
        $this->isCorrect = $isCorrect;
        return $this;
    }

    public function getMistakeType(): ?string
    {
        return $this->mistakeType;
    }

    public function setMistakeType(?string $mistakeType): static
    {
        $this->mistakeType = $mistakeType;
        return $this;
    }
}