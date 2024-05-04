<?php

declare(strict_types=1);

namespace App\Http\Services\Api\V1\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class AuthService
{
    public function registerUser(array $user_data): User
    {
        return User::query()->create([
            'name' => $user_data['name'],
            'email' => $user_data['email'],
            'password' => Hash::make(value: $user_data['password']),
        ]);
    }
}
