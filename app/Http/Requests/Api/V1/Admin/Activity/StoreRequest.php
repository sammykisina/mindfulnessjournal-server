<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Admin\Activity;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'thumbnail' => [
                'required',
                // 'mimes:png,jpg,jpeg',
            ],
            'content' => [
                'required',
                'string',
            ],
        ];
    }
}
