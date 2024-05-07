<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Activity;

use App\Http\Concerns\Response;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;
use Spatie\QueryBuilder\QueryBuilder;

final class IndexController
{
    use Response;

    public function __invoke(Request $request)
    {
        $activities = QueryBuilder::for(Activity::class)
            ->allowedSorts('created_at')
            ->allowedFilters('id', 'title')
            ->get();

        return Response::successResponse(
            data: [
                'message' => 'activities fetched successfully.',
                'activities' => ActivityResource::collection(
                    resource: $activities
                ),
            ], status: Http::OK()
        );

    }
}
