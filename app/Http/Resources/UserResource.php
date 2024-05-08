<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

/**
 * @property-read User $resource
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'user_type' => $this->resource->user_type,
            'is_super_admin' => $this->resource->is_super_admin,
            'profile_pic' => $this->resource->profile_pic ? Config::get('app.url').Storage::url($this->resource->profile_pic) : null,
        ];

    }
}
