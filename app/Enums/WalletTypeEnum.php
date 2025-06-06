<?php

namespace App\Enums;

use App\Traits\EnumValuesTrait;

enum WalletTypeEnum: string
{
    use EnumValuesTrait;

    case COMMISSION = 'commission';
    case ESCROW = 'escrow';
    case PREPAID = 'prepaid';
    case PRIMARY = 'primary';
    case SETTLEMENT = 'settlement';
    case GL = 'gl';
}
