<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Resources\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class UserController extends Controller {
    public function store(StoreUserRequest $request): JsonResponse {
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->email),
            'mobile_number' => $request->mobile_number,
            'role' => $request->role,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'created_by' => $request->email
        ]);
        return (new UserResource($user))->response(JsonResponse::HTTP_CREATED);
    }
}
