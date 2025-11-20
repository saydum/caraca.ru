<?php

namespace App\Enums;

enum ModerationAdStatus: string
{
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case REJECTED = 'rejected';
}
