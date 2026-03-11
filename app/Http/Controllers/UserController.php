<?php

namespace App\Http\Controllers;

use App\DTO\User\CreateUserDTO;
use App\DTO\User\UpdateUserDTO;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserServiceInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use AuthorizesRequests,
        ValidatesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', User::class);
        
        return response()->json(User::all()->map(fn($item) => new UserResource($item)));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request, UserServiceInterface $userService)
    {
        $data = $request->validated();

        $dto = new CreateUserDTO(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            phone: $data['phone']
        );

        $user = $userService->create($dto);

        return response()->json(new UserResource($user), JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);
        
        return response()->json(new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user, UserServiceInterface $userService)
    {
        $data = $request->validated();

        $dto = new UpdateUserDTO(
            name: $data['name'] ?? null,
            email: $data['email'] ?? null,
            password: $data['password'] ?? null,
            phone: $data['phone'] ?? null
        );

        $user = $userService->update($user, $dto);
        return response()->json(new UserResource($user));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, UserServiceInterface $userService)
    {
        $this->authorize('delete', $user);

        $userService->delete($user);

        return response()->json([], JsonResponse::HTTP_NO_CONTENT);
    }
}
