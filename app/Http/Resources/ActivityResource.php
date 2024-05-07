<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class ActivityResource extends JsonResource
{
    /**
     * @property-read Activity $resource
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'thumbnail' => Config::get('app.url').Storage::url($this->resource->thumbnail),
            'content' => $this->resource->content,
        ];
    }
}
