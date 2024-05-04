<?php

declare(strict_types=1);

namespace App\Http\Concerns;

use Illuminate\Http\JsonResponse;

trait Response
{
    public static function successResponse(
        array $data,
        int $status = 202
    ): JsonResponse {
        return new JsonResponse(
            data: $data,
            status: $status
        );
    }

    public static function errorResponse(
        array $data,
        int $status = 501
    ): JsonResponse {
        return new JsonResponse(
            data: $data,
            status: $status
        );
    }
}
