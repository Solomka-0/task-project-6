<?php

namespace App\Enums;

enum Role: string
{
    case ADMIN = 'admin';
    case WORKER = 'worker';
    case MANAGER = 'manager';
}
