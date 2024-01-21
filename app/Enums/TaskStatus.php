<?php

namespace App\Enums;

enum TaskStatus
{
    const STATUS_TODO = 'TODO';
    const STATUS_DOING = 'DOING';
    const STATUS_DONE = 'DONE';
    const STATUS = [self::STATUS_TODO, self::STATUS_DOING, self::STATUS_DONE];
}
