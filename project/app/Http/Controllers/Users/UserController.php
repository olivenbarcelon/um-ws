<?php

namespace App\Http\Controllers\Users;

use App\Jobs\UserCsvProcess;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\Users\ShowUserRequest;
use App\Http\Requests\Users\LoginUserRequest;
use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\DeleteUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;

class UserController extends Controller {
    protected $userRepository;

    /**
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }

    /**
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse {
        $user = $this->userRepository->save([
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
        $user = $this->userRepository->findAll();
        return UserResource::collection($user)->response();
    }

    /**
     * @param ShowUserRequest $request
     * @return JsonResponse
     */
    public function show(ShowUserRequest $request): JsonResponse {
        $user = $this->userRepository->findByUuid($request->uuid);
        return (new UserResource($user))->response();
    }

    /**
     * @param UpdateUserRequest $request
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request): JsonResponse {
        $user = $this->userRepository->saveByUuid($request->uuid, [
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name
        ]);
        return (new UserResource($user))->response();
    }

    /**
     * @param DeleteUserRequest $request
     * @return JsonResponse
     */
    public function destroy(DeleteUserRequest $request): JsonResponse {
        $this->userRepository->delete($request->uuid);
        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function upload(Request $request): JsonResponse {
        if($request->has('file')) {
            $header = [];
            $data = file($request->file);
            $chunks = array_chunk($data, 1000);
            foreach($chunks as $key => $chunk) {
                $data = array_map('str_getcsv', $chunk);
                if($key === 0) {
                    $header = $data[0];
                    unset($data[0]);
                }
                UserCsvProcess::dispatch($data, $header, $this->userRepository);
            }

            return response()->json([
                'message' => 'Users has successfully uploaded'
            ]);
        }
        return response()->json([
            'message' => 'No file uploaded or invalid file type'
        ], JsonResponse::HTTP_NOT_ACCEPTABLE);
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
