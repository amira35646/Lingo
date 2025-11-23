<?php

namespace App\Enum;

enum UserRole: string
{
    case ADMIN = 'ADMIN';
    case USER = 'USER';
    case LEARNER = 'LEARNER';
    case MANAGER = 'MANAGER';
}
