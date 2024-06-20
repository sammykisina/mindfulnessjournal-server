<?php

namespace App\Http\Controllers\Api\V1\Admin\Activity;

use App\Http\Concerns\Response;
use App\Models\Activity;
use JustSteveKing\StatusCode\Http;

class DeleteController 
{
    use Response;
    
    public function __invoke(Activity $activity)
    {
         if($activity->delete()) {
            return Response::successResponse(
                data:[
                    'message' => 'Activity deleted successfully.',
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
