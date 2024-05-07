<?php

declare(strict_types=1);

namespace App\Http\Services\Api\V1\Admin\Activity;

use App\Models\Activity;

final class ActivityService
{
    public function storeActivity(array $activity_data): Activity
    {
        return Activity::query()->create([
            'title' => $activity_data['title'],
            'thumbnail' => $activity_data['thumbnail'],
            'content' => $activity_data['content'],
        ]);
    }

    public function updateCount(Activity $activity): bool
    {
        return $activity->update([
            'count' => $activity->count + 1,
        ]);
    }
}
