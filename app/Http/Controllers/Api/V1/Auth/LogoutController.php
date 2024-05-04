<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Concerns\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

final class LogoutController
{
    use Response;

    public function __invoke(Request $request): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return Response::successResponse(
            data: [
                'message' => 'Wish to  see u again soon .',
            ],
            status: Http::ACCEPTED()
        );
    }
}
