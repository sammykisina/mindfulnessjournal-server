<?php

declare(strict_types=1);

namespace App\Http\Services\Api\V1\Admin\User;

use App\Http\Enums\UserTypes;
use App\Models\User;

final class UserService
{
    public function makeUserAdmin(User $user): bool
    {
        return $user->update([
            'user_type' => UserTypes::ADMIN->value,
        ]);
    }
}
