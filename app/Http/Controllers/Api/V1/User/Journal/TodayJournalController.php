<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User\Journal;

use App\Http\Concerns\Response;
use App\Http\Resources\JournalResource;
use App\Models\Journal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use JustSteveKing\StatusCode\Http;
use Spatie\QueryBuilder\QueryBuilder;

final class TodayJournalController
{
    use Response;

    public function __invoke(Request $request)
    {
        $journal = QueryBuilder::for(Journal::class)
            ->allowedSorts('-created_at')
            ->allowedFilters('id')
            ->where('user_id', auth()->user()->id)
            ->whereDate('created_at', '=', Carbon::now())
            ->first();

        return Response::successResponse(
            data: [
                'message' => 'todays journal fetched successfully.',
                'journal' => $journal ? new JournalResource(
                    resource: $journal
                ) : null,
            ], status: Http::OK()
        );
    }
}
