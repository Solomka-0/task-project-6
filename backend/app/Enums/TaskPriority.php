<?php

namespace App\Enums;

enum TaskPriority: int
{
    case DEFAULT = 0;
    case LOW = 1;
    case MEDIUM = 2;
    case HIGH = 3;
}
