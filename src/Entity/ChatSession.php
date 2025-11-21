<?php

namespace App\Entity;

use App\Repository\ChatSessionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChatSessionRepository::class)]
Class ChatSession
{
    #[ORM\Id]

    #[ORM\Column(length: 255)]
    private ?string $chat_id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $start_time = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $end_time = null;

    public function getId(): ?int
    {
        return $this->chat_id;
    }

    public function getChatId(): ?string
    {
        return $this->chat_id;
    }

    public function setChatId(string $chat_id): static
    {
        $this->chat_id = $chat_id;

        return $this;
    }

    public function getStartTime(): ?\DateTime
    {
        return $this->start_time;
    }

    public function setStartTime(\DateTime $start_time): static
    {
        $this->start_time = $start_time;

        return $this;
    }

    public function getEndTime(): ?\DateTime
    {
        return $this->end_time;
    }

    public function setEndTime(\DateTime $end_time): static
    {
        $this->end_time = $end_time;

        return $this;
    }
}
