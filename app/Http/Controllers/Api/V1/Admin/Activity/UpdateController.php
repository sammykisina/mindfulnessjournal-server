<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Activity;

use App\Http\Concerns\Response;
use App\Http\Requests\Api\V1\Admin\Activity\UpdateActivity;
use App\Http\Services\Api\V1\Admin\Activity\ActivityService;
use App\Models\Activity;
use JustSteveKing\StatusCode\Http;

final class UpdateController
{
    use Response;

    public function __construct(
        protected ActivityService $activityService
    ){}

    public function __invoke(UpdateActivity $request,Activity $activity)
    {
        if($this->activityService->updateActivity(
            activity_data: $request->validated(),
          activity: $activity  
        )) {
            return Response::successResponse(
                data:[
                    'message' => 'Activity updated successfully.',
                ],
                status: Http::ACCEPTED()
            );
        }

         return Response::errorResponse(
                data:[
                    'message' => 'Something went wrong.',
                ],
                status: Http::NOT_MODIFIED()
            );
    }
}
