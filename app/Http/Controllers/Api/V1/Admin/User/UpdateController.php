<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\User;

use App\Http\Concerns\Response;
use App\Http\Requests\Api\V1\Admin\User\UpdateRequest;
use App\Http\Services\Api\V1\Admin\User\UserService;
use App\Models\User;
use App\Notifications\Api\V1\Admin\User\AccountUpdated;
use JustSteveKing\StatusCode\Http;

final class UpdateController
{
    use Response;

    public function __construct(
        protected UserService $userService
    ) {
    }

    public function __invoke(UpdateRequest $request, User $user)
    {

        if (! $this->userService->updateUser(
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

        $updatedUser = User::query()->where('email', $request->validated()['email'])->first();

        $updatedUser->notify(new AccountUpdated(password: $request->validated()['password']));

        return Response::successResponse(
            data: [
                'message' => 'Account updated successfully.',
            ],
            status: Http::ACCEPTED()
        );
    }
}
