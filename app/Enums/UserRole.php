<?php

namespace App\Enums;


enum UserRole: string
{
    case CLIENT = 'user';
    case ADMIN = 'admin';
    case SUPERADMIN = 'superadmin';
}
