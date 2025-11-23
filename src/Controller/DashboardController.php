<?php

namespace App\Controller;
use Doctrine\DBAL\Logging\Middleware;
use Doctrine\DBAL\Logging\DebugStack;
use App\Repository\UserRepository;
use App\Repository\RoomRepository;
use App\Repository\QuizRepository;
use App\Repository\ChatMessageRepository;
use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

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

        // ✅ Use count queries instead of loading all entities
        $stats = [
            'total_users' => $userRepository->count([]),
            'total_rooms' => $roomRepository->count([]),
            'total_quizzes' => $quizRepository->count([]),
            'total_messages' => $chatMessageRepository->count([]),
            'total_topics' => $topicRepository->count([]),
        ];






        $recentUsers = $userRepository->findRecentUsers(5);
        $recentRooms = $roomRepository->findRecentRooms();



        return $this->render('dashboard/index.html.twig', [
            'stats' => $stats,
            'recent_users' => $recentUsers,
            'recent_rooms' => $recentRooms,
        ]);
    }

}