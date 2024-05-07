<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User\Journal;

use App\Http\Concerns\Response;
use App\Models\Journal;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

final class IndexController
{
    use Response;

    public function __invoke(Request $request)
    {
        $journals = QueryBuilder::for(Journal::class)
            ->allowedSorts('-date')
            ->allowedFilters('id')
            ->get();

        //      return Response::successResponse(
        //     data: [
        //         'message' => 'users fetched successfully.',
        //         // 'journal' => ::collection(
        //         //     resource: $users
        //         // ),
        //     ], status: Http::OK()
        // );
    }
}
