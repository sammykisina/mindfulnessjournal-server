<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\V1\User\Journal;

use Illuminate\Foundation\Http\FormRequest;

class StoreJournalRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'feeling' => [
                'string',
                'required',
            ],
            'emoji' => [
                'string',
                'required',
            ],
            'date' => [
                'string',
                'required',
            ],
        ];
    }
}
