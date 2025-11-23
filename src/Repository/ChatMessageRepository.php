<?php

namespace App\Repository;

use App\Entity\ChatMessage;
use App\Entity\ChatSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ChatMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChatMessage::class);
    }

    /**
     * Find messages for a session with sender information preloaded
     */
    public function findBySessionWithSenders(ChatSession $session): array
    {
        return $this->createQueryBuilder('m')
            ->where('m.session = :session')
            ->setParameter('session', $session)
            ->orderBy('m.timestamp', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find messages with minimal data for list display
     */
    public function findBySessionAsArray(int $sessionId): array
    {
        return $this->createQueryBuilder('m')
            ->select('m.id', 'm.content', 'm.senderName', 'm.senderType', 'm.timestamp')
            ->where('m.session = :sessionId')
            ->setParameter('sessionId', $sessionId)
            ->orderBy('m.timestamp', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }
}