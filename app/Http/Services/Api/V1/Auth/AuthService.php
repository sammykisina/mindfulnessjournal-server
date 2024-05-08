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

    public function updateUser(array $updated_user_data, User $user): bool
    {
        return $user->update([
            'name' => $updated_user_data['name'],
            'email' => $updated_user_data['email'],
            'password' => Hash::make(value: $updated_user_data['password']),
        ]);
    }

    public function updateProfilePic(string $profile_pic, User $user): bool
    {
        return $user->update([
            'profile_pic' => $profile_pic,
        ]);
    }

    public function generateTwoFactorCode(User $user): bool
    {
        return $user->update([
            'two_factor_code' => rand(100000, 999999),
            'two_factor_expires_at' => now()->addMinutes(10),
        ]);
    }

    public function resetPassword(string $password, User $user): bool
    {
        return $user->update([
            'password' => Hash::make(value: $password),
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);
    }
}
