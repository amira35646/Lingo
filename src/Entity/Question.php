<?php

namespace App\Entity;

use App\Repository\QuestionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuestionRepository::class)]
class Question
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_question = null;

    #[ORM\Column(length: 255)]
    private ?string $text = null;

    #[ORM\Column(length: 255)]
    private ?string $reponsecorrecte = null;

    public function getId(): ?int
    {
        return $this->id_question;
    }

    public function getIdQuestion(): ?int
    {
        return $this->id_question;
    }

    public function setIdQuestion(int $id_question): static
    {
        $this->id_question = $id_question;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getReponsecorrecte(): ?string
    {
        return $this->reponsecorrecte;
    }

    public function setReponsecorrecte(string $reponsecorrecte): static
    {
        $this->reponsecorrecte = $reponsecorrecte;

        return $this;
    }
}
