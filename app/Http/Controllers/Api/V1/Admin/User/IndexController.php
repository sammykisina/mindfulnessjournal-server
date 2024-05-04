<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\User;

use App\Http\Concerns\Response;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use JustSteveKing\StatusCode\Http;
use Spatie\QueryBuilder\QueryBuilder;

final class IndexController
{
    use Response;

    public function __invoke(): JsonResponse
    {
        $users = QueryBuilder::for(User::class)
            ->allowedSorts('id')
            ->allowedFilters('id', 'name')
            ->get();

        return Response::successResponse(
            data: [
                'message' => 'all users fetched successfully.',
                'users' => UserResource::collection(
                    resource: $users
                ),
            ], status: Http::OK()
        );
    }
}
