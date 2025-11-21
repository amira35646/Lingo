<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Repository\UserRepository;
use App\Repository\RoomRepository;
use App\Repository\QuizRepository;
use App\Repository\ChatMessageRepository;
use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends AbstractController
{
    #[Route('/quiz', name: 'app_quiz_index')]
    public function index(QuizRepository $quizRepository,): Response
    {

        $quizzes=$quizRepository->findAll();
        return $this->render('quiz/index.html.twig', [
            'quizzes' => $quizzes, // this must match your template variable
        ]);
    }

    #[Route('/quiz/new', name: 'app_quiz_new')]
    public function new(  QuizRepository $quizRepository,): Response
    {
        $quizzes=$quizRepository->findAll();
        return $this->render('quiz/index.html.twig', [
            'quizzes' => $quizzes, // this must match your template variable
        ]);


    }
}