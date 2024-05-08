<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ProfilePicUploadRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'avatar' => ['required'],
        ];
    }
}
