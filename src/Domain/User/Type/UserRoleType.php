<?php

namespace App\Domain\User\Type;

/**
 * Type.
 */
final class UserRoleType
{
    /** @var int */
    public const ROLE_SUPER_ADMIN = 1;

    /** @var int */
    public const ROLE_ADMIN = 2;

    /** @var int */
    public const ROLE_USER = 3;
    
    /** @var int */
    public const ROLE_CUSTOMER = 4;
}
