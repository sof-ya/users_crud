<?php

namespace App\DTO\User;

use App\Enums\UserRoleEnum;

readonly class UpdateUserDTO
{

    public function __construct(
            public ?string $name = null,
            public ?string $email = null,
            public ?string $password = null,
            public ?int $phone = null
    )
    {
        
    }
}
