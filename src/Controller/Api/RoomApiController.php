<?php

namespace App\Controller\Api;

use App\Entity\Room;
use App\Enum\RoomStatus;
use App\Repository\RoomRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/rooms')]
class RoomApiController extends AbstractController
{
    #[Route('/available', name: 'api_rooms_available', methods: ['GET'])]
    public function available(RoomRepository $repo): JsonResponse
    {
        // For now, return all rooms; optionally filter by status AVAILABLE
        $rooms = $repo->findAll();

        $data = array_map(function (Room $room) {
            return [
                'id' => $room->getRoomId(),
                'topic' => $room->getTopic(),
                'targetLanguage' => $room->getTargetLanguage(),
                'proficiencyLevel' => $room->getProficiencyLevel(),
                'maxParticipants' => $room->getMaxParticipants(),
                'scheduledTime' => $room->getScheduledTime()?->format('c'),
                'durationMinutes' => $room->getDurationMinutes(),
                'createdBy' => $room->getCreatedBy(),
                'status' => $room->getRoomStatus()?->value,
                // Avoid serializing full User objects to keep it simple
                'participants' => [],
            ];
        }, $rooms);

        return $this->json($data);
    }

    #[Route('/create', name: 'api_rooms_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $payload = json_decode($request->getContent(), true) ?? [];

        $required = ['topic', 'targetLanguage', 'proficiencyLevel', 'maxParticipants', 'scheduledTime', 'durationMinutes'];
        foreach ($required as $field) {
            if (!array_key_exists($field, $payload) || $payload[$field] === '' || $payload[$field] === null) {
                return $this->json(['error' => "Field $field is required"], 400);
            }
        }

        // Basic constraints
        $maxParticipants = (int) $payload['maxParticipants'];
        if ($maxParticipants < 2 || $maxParticipants > 20) {
            return $this->json(['error' => 'maxParticipants must be between 2 and 20'], 400);
        }

        $duration = (int) $payload['durationMinutes'];
        $allowedDurations = [15, 30, 45, 60];
        if (!in_array($duration, $allowedDurations, true)) {
            return $this->json(['error' => 'durationMinutes must be one of 15, 30, 45, 60'], 400);
        }

        try {
            $scheduled = new \DateTime($payload['scheduledTime']);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Invalid scheduledTime format'], 400);
        }

        if ($scheduled < new \DateTime()) {
            return $this->json(['error' => 'scheduledTime must be in the future'], 400);
        }

        $room = new Room();
        $room->setTopic((string) $payload['topic']);
        $room->setTargetLanguage((string) $payload['targetLanguage']);
        $room->setProficiencyLevel((string) $payload['proficiencyLevel']);
        $room->setMaxParticipants($maxParticipants);
        $room->setScheduledTime($scheduled);
        $room->setDurationMinutes($duration);

        // Use current authenticated user identifier, fallback to provided createdBy, then 'anonymous'
        $createdBy = $this->getUser()?->getUserIdentifier() ?? ($payload['createdBy'] ?? 'anonymous');
        $room->setCreatedBy((string) $createdBy);
        $room->setCreatedAt(new \DateTimeImmutable());
        $room->setRoomStatus(RoomStatus::AVAILABLE);

        $em->persist($room);
        $em->flush();

        return $this->json([
            'id' => $room->getRoomId(),
            'topic' => $room->getTopic(),
            'targetLanguage' => $room->getTargetLanguage(),
            'proficiencyLevel' => $room->getProficiencyLevel(),
            'maxParticipants' => $room->getMaxParticipants(),
            'scheduledTime' => $room->getScheduledTime()?->format('c'),
            'durationMinutes' => $room->getDurationMinutes(),
            'createdBy' => $room->getCreatedBy(),
            'status' => $room->getRoomStatus()?->value,
            'participants' => [],
        ], 201);
    }
}
