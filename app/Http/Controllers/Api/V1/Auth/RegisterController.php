<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Concerns\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\Api\V1\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use JustSteveKing\StatusCode\Http;

class RegisterController extends Controller
{
    use Response;

    public function __construct(
        public AuthService $authService
    ) {
    }

    public function __invoke(RegisterRequest $request): JsonResponse
    {
        $data = DB::transaction(function () use ($request) {
            $user = $this->authService->registerUser(user_data: $request->validated());
            $user = $user->refresh();
            $user_access_token = $user->createToken(name: 'access_token')->plainTextToken;

            return [
                'message' => 'Registered successful.',
                'user' => new UserResource(
                    resource: $user
                ),
                'access_token' => $user_access_token,
            ];
        });

        return Response::successResponse(
            data: $data, status: Http::CREATED()
        );
    }
}
