<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Concerns\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Auth\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use JustSteveKing\StatusCode\Http;

class LoginController extends Controller
{
    use Response;

    public function __invoke(LoginRequest $request)
    {
        $user = User::query()->where('email', $request->validated()['email'])->first();
        if (! $user) {
            return Response::errorResponse(
                data: [
                    'message' => 'User with that email is not found.',
                ],
                status: Http::UNAUTHORIZED()
            );
        }

        if (! Hash::check($request->validated()['password'], $user->password)) {
            return Response::errorResponse(
                data: [
                    'message' => 'Wrong password.',
                ],
                status: Http::UNAUTHORIZED()
            );
        }

        $user_access_token = $user->createToken(name: 'access_token')->plainTextToken;

        return Response::successResponse(
            data: [
                'message' => 'Login successful.',
                'user' => new UserResource(
                    resource: $user
                ),
                'access_token' => $user_access_token,
            ],
            status: Http::ACCEPTED()
        );
    }
}
