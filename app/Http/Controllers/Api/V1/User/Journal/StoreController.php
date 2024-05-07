<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User\Journal;

use App\Http\Concerns\Response;
use App\Http\Requests\Api\V1\User\Journal\StoreJournalRequest;
use App\Http\Resources\JournalResource;
use App\Http\Services\Api\V1\User\JournalService;
use JustSteveKing\StatusCode\Http;

final class StoreController
{
    use Response;

    public function __construct(
        protected JournalService $journalService
    ) {
    }

    public function __invoke(StoreJournalRequest $request)
    {
        $journal = $this->journalService->storeJournal(
            journal_data: $request->validated()
        );

        if ($journal) {
            return Response::successResponse(
                data: [
                    'message' => 'Journal created successfully.',
                    'activity' => new JournalResource(
                        resource: $journal
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
