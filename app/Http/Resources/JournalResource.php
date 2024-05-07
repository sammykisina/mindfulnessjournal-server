<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Journal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Journal $resource
 */
class JournalResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'feeling' => $this->resource->feeling,
            'emoji' => $this->resource->emoji,
            'date' => Carbon::parse($this->resource->date)->format('l jS \of F Y h:i:s A'),
            'daily_gratitude' => $this->resource->daily_gratitude,
        ];
    }
}
