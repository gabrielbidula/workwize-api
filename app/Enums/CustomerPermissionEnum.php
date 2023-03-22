<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

final class CustomerPermissionEnum extends Enum
{
    public const VIEW_ANY_PRODUCT = 'view any product';

    public const CREATE_CART = 'create cart';

    public const VIEW_CART = 'view cart';

    public const DELETE_CART = 'delete cart';

    public const CLEAR_CART = 'clear cart';

    public const ADD_PRODUCT_TO_CART = 'add product to cart';

    public const REMOVE_PRODUCT_FROM_CART = 'remove product from cart';
}
