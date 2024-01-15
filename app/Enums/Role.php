<?php

namespace App\Enums;

enum Role
{
    const ROLE_OWNER = 'OWNER';
    const ROLE_MEMBER = 'MEMBER';
    const ROLE_VIEWER = 'VIEWER';
    const ROLE = [self::ROLE_OWNER, self::ROLE_MEMBER, self::ROLE_VIEWER];
}
