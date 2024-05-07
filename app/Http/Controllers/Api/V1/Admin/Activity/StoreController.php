<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Activity;

use App\Http\Concerns\Response;
use App\Http\Requests\Api\V1\Admin\Activity\StoreRequest;
use App\Http\Resources\ActivityResource;
use App\Http\Services\Api\V1\Admin\Activity\ActivityService;
use JustSteveKing\StatusCode\Http;

final class StoreController
{
    use Response;

    public function __construct(
        public ActivityService $activityService
    ) {
    }

    public function __invoke(StoreRequest $request)
    {
        if ($request->has('thumbnail')) {
            $file = $request->file('thumbnail');
            $fileName = time().'.'.$file->getClientOriginalName();
            $path = $file->storeAs('uploads/activities/thumbnails', $fileName, 'public');
        }

        $activity = $this->activityService->storeActivity(
            activity_data: [
                'title' => $request->validated()['title'],
                'content' => $request->validated()['content'],
                'thumbnail' => $path,
            ]
        );

        if ($activity) {
            return Response::successResponse(
                data: [
                    'message' => 'Activity created successfully.',
                    'activity' => new ActivityResource(
                        resource: $activity
                    ),

                ], status: Http::CREATED()
            );
        } else {
            return Response::errorResponse(
                data: [
                    'message' => 'Something went wrong.Activity not created. Try again later.',

                ], status: Http::NOT_IMPLEMENTED()
            );
        }
    }
}
