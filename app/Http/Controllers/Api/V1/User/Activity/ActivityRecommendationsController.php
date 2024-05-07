<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User\Activity;

use App\Http\Concerns\Response;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;
use Spatie\QueryBuilder\QueryBuilder;

final class ActivityRecommendationsController
{
    use Response;

    public function __invoke(Request $request)
    {
        $activities = QueryBuilder::for(Activity::class)
         ->allowedFilters('title')
            ->where('count', '>=', 5)
            ->limit(5)
            ->get();

        return Response::successResponse(
            data: [
                'message' => 'recommendations activities fetched successfully.',
                'activities' => ActivityResource::collection(
                    resource: $activities
                ),
            ], status: Http::OK()

        );
    }
}
