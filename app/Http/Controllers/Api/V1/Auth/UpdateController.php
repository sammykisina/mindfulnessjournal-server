<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Concerns\Response;
use App\Http\Requests\Api\V1\Admin\User\UpdateRequest;
use App\Http\Services\Api\V1\Auth\AuthService;
use App\Models\User;
use App\Notifications\Api\V1\Admin\User\AccountUpdated;
use JustSteveKing\StatusCode\Http;

final class UpdateController
{
    use Response;

    public function __construct(
        protected AuthService $authService
    ) {
    }

    public function __invoke(UpdateRequest $request, User $user)
    {

        if (! $this->authService->updateUser(
            updated_user_data: $request->validated(),
            user: $user
        )) {
            return Response::errorResponse(
                data: [
                    'message' => 'Account not updated! Please try again later.',
                ],
                status: Http::NOT_MODIFIED()
            );
        }

        if (auth()->user()->user_type === 'admin') {
            // $updatedUser = User::query()->where('email', $request->validated()['email'])->first();
            $updated_user = $user->refresh();
            $updated_user->notify(new AccountUpdated(password: $request->validated()['password']));
        }

        return Response::successResponse(
            data: [
                'message' => 'Account updated successfully.',
            ],
            status: Http::ACCEPTED()
        );
    }
}
