<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Concerns\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

final class ProfileController
{
    use Response;

    public function __invoke(Request $request): JsonResponse
    {
        return Response::successResponse(
            data: [
                'user' => auth()->user(),
                'message' => 'Fetched user profile successfully.',
            ],
            status: Http::OK()
        );
    }
}
