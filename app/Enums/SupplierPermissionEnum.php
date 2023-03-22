<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class SupplierPermissionEnum extends Enum
{
    public const VIEW_PRODUCT = 'view product';

    public const CREATE_PRODUCT = 'create product';

    public const DELETE_PRODUCT = 'delete product';

    public const UPDATE_PRODUCT = 'update product';
}
