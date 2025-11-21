<?php

namespace App\Enum;

enum RoomStatus: string
{
    case AVAILABLE = 'available';
    case OCCUPIED = 'occupied';
    case MAINTENANCE = 'maintenance';
    case CLOSED = 'closed';
}