<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Admin\Activity;

use Illuminate\Foundation\Http\FormRequest;

class ActivityImageUpload extends FormRequest
{
    public function rules(): array
    {
        return [
            'image' => [
                'required',
            ],
        ];
    }
}
