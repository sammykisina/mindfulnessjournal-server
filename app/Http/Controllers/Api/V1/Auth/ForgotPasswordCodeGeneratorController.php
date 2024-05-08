<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Concerns\Response;
use App\Http\Services\Api\V1\Auth\AuthService;
use App\Models\User;
use App\Notifications\Api\V1\Admin\User\SendPasswordResetCode;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

final class ForgotPasswordCodeGeneratorController
{
    use Response;

    public function __construct(
        protected AuthService $authService
    ) {
    }

    public function __invoke(Request $request)
    {
        $user = User::query()->where('email', $request->get(key: 'email'))->first();

        if (! $user) {
            return Response::errorResponse(
                data: [
                    'message' => 'No account found',
                ],
                status: Http::NOT_ACCEPTABLE()
            );
        }

        if ($this->authService->generateTwoFactorCode(user: $user)) {
            $user = $user->refresh();
            $user->notify(new SendPasswordResetCode);

            return Response::successResponse(
                data: [
                    'message' => 'Check your email for code',
                ],
                status: Http::ACCEPTED()
            );
        } else {
            return Response::errorResponse(
                data: [
                    'message' => 'No account found',
                ],
                status: Http::NOT_ACCEPTABLE()
            );
        }
    }
}
