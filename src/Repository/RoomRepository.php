<?php

namespace App\Repository;

use App\Entity\Room;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RoomRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Room::class);
    }

    /**
     * Find rooms with all relations eager loaded (use when you need full room data)
     */
    public function findAllWithRelations(): array
    {
        return $this->createQueryBuilder('r')
            ->leftJoin('r.topic', 't')
            ->leftJoin('r.targetLanguage', 'l')
            ->leftJoin('r.proficiencyLevel', 'p')
            ->addSelect('t', 'l', 'p')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find one room with relations
     */
    public function findOneWithRelations(int $id): ?Room
    {
        return $this->createQueryBuilder('r')
            ->leftJoin('r.topic', 't')
            ->leftJoin('r.targetLanguage', 'l')
            ->leftJoin('r.proficiencyLevel', 'p')
            ->addSelect('t', 'l', 'p')
            ->where('r.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Find rooms with participants count (efficient)
     */
    public function findAllWithParticipantCount(): array
    {
        return $this->createQueryBuilder('r')
            ->select('r', 'COUNT(p.id) as participantCount')
            ->leftJoin('r.participants', 'p')
            ->groupBy('r.id')
            ->getQuery()
            ->getResult();
    }
    public function findRecentRooms(int $limit = 5): array
    {
        return $this->createQueryBuilder('r')
            ->select('r.id, r.maxParticipants, r.durationMinutes, r.room_status') // only needed fields
            ->setMaxResults($limit)
            ->orderBy('r.id', 'DESC')
            ->getQuery()
            ->getArrayResult();
    }

    public function save(Room $room, bool $flush = false): void
    {
        $this->getEntityManager()->persist($room);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Room $room, bool $flush = false): void
    {
        $this->getEntityManager()->remove($room);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}