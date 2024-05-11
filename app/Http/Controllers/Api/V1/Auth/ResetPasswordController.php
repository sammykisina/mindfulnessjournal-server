<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Concerns\Response;
use App\Http\Requests\Api\V1\Auth\ResetPasswordRequest;
use App\Http\Services\Api\V1\Auth\AuthService;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use JustSteveKing\StatusCode\Http;

final class ResetPasswordController
{
    use Response;

    public function __construct(
        protected AuthService $authService
    ) {
    }

    public function __invoke(ResetPasswordRequest $request)
    {
        Log::info('code'.$request->validated()['code']);

        $user = User::query()->where('two_factor_code', $request->validated()['code'])->first();

        if (! $user) {
            return Response::errorResponse(
                data: [
                    'message' => 'User not found! Request a new code',
                ],
                status: Http::NOT_ACCEPTABLE()
            );
        }

        if ($user->two_factor_expires_at->lt(now())) {
            return Response::errorResponse(
                data: [
                    'message' => 'Code not found! Request a new code',
                ],
                status: Http::NOT_ACCEPTABLE()
            );
        }

        if (! $this->authService->resetPassword(password: $request->validated()['password'], user: $user)) {
            return Response::errorResponse(
                data: [
                    'message' => 'Something went wrong.Try again later',
                ],
                status: Http::NOT_MODIFIED()
            );
        }

        return Response::successResponse(
            data: [
                'message' => 'Password reset successfully.',
            ],
            status: Http::ACCEPTED()
        );
    }
}
