<?php

namespace App\Enums;

enum Rule
{
    const RULE_OWNER = 'OWNER';
    const RULE_MEMBER = 'MEMBER';
    const RULE_VIEWER = 'VIEWER';
    const RULE = [self::RULE_OWNER, self::RULE_MEMBER, self::RULE_VIEWER];
}
