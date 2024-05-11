<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'thumbnail',
        'content',
        'count',
    ];

    public function assets(): HasMany
    {
        return $this->hasMany(
            related: ActivityImage::class,
            foreignKey: 'activity_id'
        );
    }
}
