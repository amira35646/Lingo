<?php

namespace App\Entity;

enum SessionStatus
{
    case IN_PROGRESS = 'EN COURS';
    case COMPLETED = 'COMPLETE';
    case CANCELLED = 'ANNULE'; /
}
