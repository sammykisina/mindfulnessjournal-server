<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User\Journal;

use App\Http\Concerns\Response;
use App\Http\Requests\Api\V1\User\Journal\StoreDailyGratitudeRequest;
use App\Http\Services\Api\V1\User\JournalService;
use App\Models\Journal;
use JustSteveKing\StatusCode\Http;

final class StoreDailyGratitudeController
{
    use Response;

    public function __construct(
        protected JournalService $journalService
    ) {
    }

    public function __invoke(StoreDailyGratitudeRequest $request, Journal $journal)
    {
        if ($this->journalService->storeDailyGratitude(
            daily_gratitude: $request->validated()['daily_gratitude'],
            journal: $journal
        )) {
            return Response::successResponse(
                data: [
                    'message' => 'Daily Gratitude created successfully.',
                ], status: Http::CREATED()
            );
        } else {
            return Response::errorResponse(
                data: [
                    'message' => 'Something went wrong.Activity not created. Try again later.',

                ], status: Http::NOT_MODIFIED()
            );
        }
    }
}
