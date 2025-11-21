<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\RoomRepository;
use App\Repository\QuizRepository;
use App\Repository\ChatMessageRepository;
use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    #[Route('/', name: 'app_dashboard')]
    public function index(
        UserRepository $userRepository,
        RoomRepository $roomRepository,
        QuizRepository $quizRepository,
        ChatMessageRepository $chatMessageRepository,
        TopicRepository $topicRepository
    ): Response {
        $stats = [
            'total_users' => count($userRepository->findAll()),
            'total_rooms' => count($roomRepository->findAll()),
            'total_quizzes' => count($quizRepository->findAll()),
            'total_messages' => count($chatMessageRepository->findAll()),
            'total_topics' => count($topicRepository->findAll()),
        ];

        $recentUsers = $userRepository->findBy([], ['user_id' => 'DESC'], 5);
        $recentRooms = $roomRepository->findBy([], ['room_id' => 'DESC'], 5);

        return $this->render('dashboard/index.html.twig', [
            'stats' => $stats,
            'recent_users' => $recentUsers,
            'recent_rooms' => $recentRooms,
        ]);
    }
}