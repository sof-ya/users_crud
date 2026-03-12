<?php

namespace App\Services;

use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\Models\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface UserServiceInterface
{
    public function create(CreateUserDTO $dto): User;

    public function update(User $user, UpdateUserDTO $dto): User;

    public function delete(User $user): void;
    
    public function updateAvatar(UploadedFile $file, User $user): void;
}
