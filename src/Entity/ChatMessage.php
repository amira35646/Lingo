<?php

namespace App\Entity;

use App\Repository\ChatMessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChatMessageRepository::class)]
class ChatMessage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $message_id = null;

    #[ORM\Column]
    private ?int $sender_id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $corrections = null;

    #[ORM\Column(length: 255)]
    private ?string $senderName = null;

    #[ORM\Column(length: 255)]
    private ?string $sendertype = null;

    #[ORM\Column(length: 255)]
    private ?string $sendername = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $timestamp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessageId(): ?int
    {
        return $this->message_id;
    }

    public function setMessageId(int $message_id): static
    {
        $this->message_id = $message_id;

        return $this;
    }

    public function getSenderId(): ?int
    {
        return $this->sender_id;
    }

    public function setSenderId(int $sender_id): static
    {
        $this->sender_id = $sender_id;

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

    public function getCorrections(): ?string
    {
        return $this->corrections;
    }

    public function setCorrections(string $corrections): static
    {
        $this->corrections = $corrections;

        return $this;
    }

    public function getSenderName(): ?string
    {
        return $this->senderName;
    }

    public function setSenderName(string $senderName): static
    {
        $this->senderName = $senderName;

        return $this;
    }

    public function getSendertype(): ?string
    {
        return $this->sendertype;
    }

    public function setSendertype(string $sendertype): static
    {
        $this->sendertype = $sendertype;

        return $this;
    }

    public function getTimestamp(): ?\DateTime
    {
        return $this->timestamp;
    }

    public function setTimestamp(\DateTime $timestamp): static
    {
        $this->timestamp = $timestamp;

        return $this;
    }
}
