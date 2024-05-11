<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Admin\Activity;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivity extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'content' => [
                'required',
                'string',
            ],
        ];
    }
}
