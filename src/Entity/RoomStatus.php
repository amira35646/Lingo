<?php
namespace App\Enum;

/**
 * Représente les différents statuts possibles d'une chambre.
 */
enum RoomStatus: string
{
    case AVAILABLE = 'available';   // Chambre libre
    case OCCUPIED = 'occupied';     // Chambre occupée
    case MAINTENANCE = 'maintenance'; // Chambre en maintenance
}
