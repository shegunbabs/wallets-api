<?php

declare(strict_types=1);

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
