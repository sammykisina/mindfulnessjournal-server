<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\User\Journal;

use App\Models\Journal;
use Carbon\Carbon;
use Illuminate\Http\Request;

final class JournalDataFoFeelingGraphController
{
    public function __invoke(Request $request)
    {
        $startDate = now()->subDays(6)->startOfDay();
        $endDate = now()->endOfDay();

        $journals = Journal::query()->whereBetween('created_at', [$startDate, $endDate])->where('user_id', auth()->user()->id)->get();

        $weeklyMoods = $journals->groupBy(function ($record) {
            return $record->created_at->format('Y-m-d');
        })->map(function ($group) {
            $maxEmoji = $group->countBy('emoji')->sortDesc()->keys()->first();
            $count = $group->where('emoji', $maxEmoji)->count();

            return [
                'emoji' => $maxEmoji,
                'count' => $count,
            ];
        })->map(function ($item, $day) {
            return [
                'emoji' => $item['emoji'],
                'count' => $item['count'],
                'day' => $day,
                'day_name' => Carbon::parse($day)->format('l'),
            ];
        })->values()->toArray();

        usort($weeklyMoods, function ($a, $b) {
            return strtotime($a['day']) <=> strtotime($b['day']);
        });

        return $weeklyMoods;

        // $records = YourModel::whereBetween('created_at', [$startDate, $endDate])->get();
    }
}
