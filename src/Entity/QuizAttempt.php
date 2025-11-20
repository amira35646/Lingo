<?php

namespace App\Entity;

use App\Repository\QuizAttemptRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuizAttemptRepository::class)]
class QuizAttempt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id_quizAtt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateStart = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $dateend = null;

    #[ORM\Column]
    private ?int $score = null;

    #[ORM\ManyToOne(targetEntity: Quiz::class, inversedBy: 'quizAttempts')]
    #[ORM\JoinColumn(name: 'quiz_id', referencedColumnName: 'quiz_id', nullable: false)]
    private ?Quiz $quiz = null;

    public function getId(): ?int
    {
        return $this->id_quizAtt;
    }

    public function getIdQuizAtt(): ?int
    {
        return $this->id_quizAtt;
    }

    public function setIdQuizAtt(int $id_quizAtt): static
    {
        $this->id_quizAtt = $id_quizAtt;

        return $this;
    }

    public function getDateStart(): ?\DateTime
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTime $dateStart): static
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateend(): ?\DateTime
    {
        return $this->dateend;
    }

    public function setDateend(\DateTime $dateend): static
    {
        $this->dateend = $dateend;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): static
    {
        $this->score = $score;

        return $this;
    }

    public function getQuiz(): ?Quiz
    {
        return $this->quiz;
    }

    public function setQuiz(?Quiz $quiz): static
    {
        $this->quiz = $quiz;

        return $this;
    }
}
