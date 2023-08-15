<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\ShowUserRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class UserController extends Controller {
    /**
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->email),
            'mobile_number' => $request->mobile_number,
            'role' => $request->role,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
        ]);
        return (new UserResource($user))->response(JsonResponse::HTTP_CREATED);
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse {
        $user = User::all();
        return UserResource::collection($user)->response();
    }

    /**
     * @param ShowUserRequest $request
     * @return JsonResponse
     */
    public function show(ShowUserRequest $request): JsonResponse {
        $user = User::whereUuid($request->uuid)->first();
        return (new UserResource($user))->response();
    }

    /**
     * @param UpdateUserRequest $request
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request): JsonResponse {
        $data = [
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
        ];
        $user = User::whereUuid($request->uuid)->first();
        $user->update($data);
        return (new UserResource($user))->response();
    }
}
