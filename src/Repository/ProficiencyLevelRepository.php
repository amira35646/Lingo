<?php

namespace App\Repository;

use App\Entity\ProficiencyLevel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProficiencyLevelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProficiencyLevel::class);
    }

    // Add custom queries if needed
}
