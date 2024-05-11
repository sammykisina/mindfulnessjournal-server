<?php

namespace App\Http\Resources;

use App\Models\ActivityImage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

/**
 * @property-read ActivityImage $resource
 */
class AssetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'asset' => Config::get('app.url').Storage::url($this->resource->image),
        ];
    }
}
