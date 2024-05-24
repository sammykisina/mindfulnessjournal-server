<?php

declare(strict_types=1);

namespace App\Http\Services\Api\V1\User;

use App\Models\Journal;
use Carbon\Carbon;

final class JournalService
{
    public function storeJournal(array $journal_data): Journal
    {
        return Journal::query()->create([
            'feeling' => $journal_data['feeling'],
            'emoji' => $journal_data['emoji'],
            'user_id' => auth()->user()->id,
        ]);
    }

    public function storeDailyGratitude(string $daily_gratitude, Journal $journal): bool
    {
        return $journal->update([
            'daily_gratitude' => $daily_gratitude,
        ]);
    }
}
