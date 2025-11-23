<?php

namespace App\Enum;

enum RoomStatus: string
{
    case AVAILABLE = 'available';
    case OCCUPIED = 'occupied';
    case MAINTENANCE = 'maintenance';
    case WAITING = 'WAITING';
    case CLOSED = 'CLOSED';
}