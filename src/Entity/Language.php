<?php

namespace App\Entity;

use App\Repository\LanguageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LanguageRepository::class)]
class Language
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_lang = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $id_topic = null;

    #[ORM\Column(length: 255)]
    private ?string $topic_name = null;

    #[ORM\Column]
    private ?int $lan_id = null;

    #[ORM\Column(length: 255)]
    private ?string $lang_name = null;

    public function getId(): ?int
    {
        return $this->id_lang;
    }

    public function getIdLang(): ?int
    {
        return $this->id_lang;
    }

    public function setIdLang(int $id_lang): static
    {
        $this->id_lang = $id_lang;

        return $this;
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

    public function getIdTopic(): ?int
    {
        return $this->id_topic;
    }

    public function setIdTopic(int $id_topic): static
    {
        $this->id_topic = $id_topic;

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

    public function getLanId(): ?int
    {
        return $this->lan_id;
    }

    public function setLanId(int $lan_id): static
    {
        $this->lan_id = $lan_id;

        return $this;
    }

    public function getLangName(): ?string
    {
        return $this->lang_name;
    }

    public function setLangName(string $lang_name): static
    {
        $this->lang_name = $lang_name;

        return $this;
    }
}
