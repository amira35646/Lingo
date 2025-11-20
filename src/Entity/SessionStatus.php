<?php

namespace App\Entity;

enum SessionStatus : string
{
    case IN_PROGRESS = 'EN COUR';
    case COMPLETED = 'COMPLETE';
    case CANCELLED = 'ANNULE';
}
