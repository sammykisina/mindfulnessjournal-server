<?php

declare(strict_types=1);

namespace App\Http\Services\Api\V1\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class UserService
{
    public function updateUser(array $updated_user_data, User $user): bool
    {
        return $user->update([
            'name' => $updated_user_data['name'],
            'email' => $updated_user_data['email'],
            'password' => Hash::make(value: $updated_user_data['password']),
        ]);
    }
}
