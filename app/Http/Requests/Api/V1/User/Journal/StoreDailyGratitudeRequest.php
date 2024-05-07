<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\User\Journal;

use Illuminate\Foundation\Http\FormRequest;

class StoreDailyGratitudeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'daily_gratitude' => [
                'required',
                'string',
            ],
        ];
    }
}
