<?php

namespace App\Entity;

use App\Repository\TopicRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TopicRepository::class)]
class Topic
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $topic_id = null;

    #[ORM\Column(length: 255)]
    private ?string $topic_name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTopicId(): ?int
    {
        return $this->topic_id;
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
}
