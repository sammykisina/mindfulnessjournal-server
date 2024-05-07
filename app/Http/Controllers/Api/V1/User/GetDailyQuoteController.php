<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User;

use App\Http\Concerns\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

final class GetDailyQuoteController
{
    use Response;

    public function __invoke(Request $request)
    {

        $response = Http::get('http://api.forismatic.com/api/1.0/?method=getQuote&format=json&lang=en');

        if ($response->status() === 200) {
            return Response::successResponse(
                data: [
                    'message' => 'Quote fetched successfully.',
                    'quote' => $response['quoteText'],

                ], status: $response->status()
            );
        } else {
            return Response::errorResponse(
                data: [
                    'message' => 'Something went wrong.',
                ], status: $response->status()
            );
        }

    }
}
