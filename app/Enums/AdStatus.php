<?php

namespace App\Enums;

enum AdStatus: string
{
    case ACTIVE = 'active';
    case SOLD_HERE = 'sold_here';
    case SOLD_ELSEWHERE = 'sold_elsewhere';
    case REMOVED = 'removed';
}
