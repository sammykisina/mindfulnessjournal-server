<?php

declare(strict_types=1);

namespace App\Http\Enums;

enum UserTypes: string
{
    case ADMIN = 'admin';
    case USER = 'user';
}
