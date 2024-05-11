<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Admin\Activity;

use App\Http\Concerns\Response;
use App\Http\Requests\Api\V1\Admin\Activity\ActivityImageUpload;
use App\Models\Activity;
use App\Models\ActivityImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use JustSteveKing\StatusCode\Http;

final class ActivityImageController
{
    use Response;

    public function uploadImage(ActivityImageUpload $request, Activity $activity)
    {

        if ($request->has('image')) {
            $file = $request->file('image');
            $fileName = time().'.'.$file->getClientOriginalName();
            $path = $file->storeAs('uploads/activities/images', $fileName, 'public');

            ActivityImage::query()->create([
                'activity_id' => $activity->id,
                'image' => $path,
            ]);

            return Response::successResponse(
                data: [
                    'message' => 'Image uploaded successfully.',
                ],
                status: Http::ACCEPTED()
            );
        } else {
            return Response::errorResponse(
                data: [
                    'message' => 'Image not found',
                ],
                status: Http::NOT_ACCEPTABLE()
            );
        }
    }

    public function deleteImage(ActivityImage $activityImage)
    {
       
        Storage::delete($activityImage->image);

        if ($activityImage->delete()) {
            return Response::successResponse(
                data: [
                    'message' => 'Image deleted successfully.',
                ],
                status: Http::ACCEPTED()
            );
        }

        return Response::errorResponse(
            data: [
                'message' => 'Something went wrong',
            ],
            status: Http::NOT_ACCEPTABLE()
        );
    }
}
