<?php

namespace App\Services;

use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\Models\User;

class UserService implements UserServiceInterface
{
    public function create(CreateUserDTO $dto): User
    {
        return User::create([
                    'name' => $dto->name,
                    'email' => $dto->email,
                    'password' => $dto->password,
                    'phone' => $dto->phone
        ]);
    }

    public function update(User $user, UpdateUserDTO $dto): User
    {
        $user->fill(array_filter([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => $dto->password,
            'phone' => $dto->phone
        ]));

        $user->save();

        return $user;
    }

    public function delete(User $user): void
    {
        $user->delete();
        return;
    }
}
