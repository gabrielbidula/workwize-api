<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class RoleEnum extends Enum
{
    public const CUSTOMER = 'customer';

    public const SUPPLIER = 'supplier';
}
