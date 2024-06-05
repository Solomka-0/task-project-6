<?php

namespace App\Enums;

enum TaskStatus: string
{
    case NOT_STARTED = 'not started';
    case IN_PROCESS = 'in process';
    case COMPLETE = 'complete';
}
