<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\User;

use App\Http\Concerns\Response;
use App\Http\Services\Api\V1\Admin\User\UserService;
use App\Models\User;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

final class MakeUserAdminController
{
    use Response;

    public function __construct(
        protected UserService $userService
    ) {
    }

    public function __invoke(Request $request, User $user)
    {
        if (! $this->userService->makeUserAdmin(user : $user)) {
            return Response::errorResponse(
                data: [
                    'message' => 'Something went wrong',

                ], status: Http::NOT_MODIFIED()
            );
        }

        return Response::successResponse(
            data: [
                'message' => 'User made admin successfully',

            ], status: Http::ACCEPTED()
        );
    }
}
