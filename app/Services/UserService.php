<?php

namespace App\Services;

use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\Models\User;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

    public function updateAvatar(UploadedFile $upload, User $user): void 
    {
        $image = Image::read($upload)
            ->crop(700, 700, (Image::read($upload)->width()-700)/2, (Image::read($upload)->height()-700)/2);

        $fileName = Str::random() . '.' . $upload->getClientOriginalExtension();
        Storage::disk('public')->put($fileName, $image->encodeByExtension($upload->getClientOriginalExtension()));
        $user->update(['avatar' => $fileName]);
    }
}
