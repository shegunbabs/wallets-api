<?php

namespace App\Enums;

use App\Traits\EnumValuesTrait;

enum WalletStatusEnum: string
{
    use EnumValuesTrait;

    case ACTIVE = 'active';
    case CLOSED = 'closed';
    case FROZEN = 'frozen';
    case SUSPENDED = 'suspended';
}
