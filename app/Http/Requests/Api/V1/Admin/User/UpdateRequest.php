<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'string',
            ],
            'email' => [
                'email',
                'required',
                Rule::unique('users', 'email')->ignore($this->user->id),
            ],
            'password' => [
                'required',
            ],
        ];
    }
}
