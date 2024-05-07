<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User\Activity;

use App\Http\Concerns\Response;
use App\Http\Services\Api\V1\Admin\Activity\ActivityService;
use App\Models\Activity;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;

final class UpdateCountController
{
    use Response;

    public function __construct(
        protected ActivityService $activityService
    ) {
    }

    public function __invoke(Request $request, Activity $activity)
    {
        if (! $this->activityService->updateCount(activity: $activity)) {
            return Response::errorResponse(
                data: [
                    'message' => 'Something went wrong',
                ],
                status: Http::NOT_MODIFIED()
            );
        }

        return Response::successResponse(
            data: [
                'message' => 'Activity count updated.',
            ],
            status: Http::ACCEPTED()
        );
    }
}
