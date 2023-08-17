<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\Users\ShowUserRequest;
use App\Http\Requests\Users\LoginUserRequest;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\DeleteUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Http\Resources\Resources\UserResource;

class UserController extends Controller {
    /**
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse {
        $user = User::create([
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'password' => $request->password,
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

    /**
     * @param DeleteUserRequest $request
     * @return JsonResponse
     */
    public function destroy(DeleteUserRequest $request): JsonResponse {
        $user = User::whereUuid($request->uuid)->first();
        $user->delete();
        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * @param LoginUserRequest $request
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request): JsonResponse {
        $credentials = $request->only(['email', 'password']);
        if(!$token = auth()->attempt($credentials)) {
            throw new UnauthorizedException();
        }

        return response()->json([
            'data' => auth()->user(),
            'token' => $token
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse {
        auth()->logout();

        return response()->json(['message' => 'User has successfully logged out']);
    }
}
