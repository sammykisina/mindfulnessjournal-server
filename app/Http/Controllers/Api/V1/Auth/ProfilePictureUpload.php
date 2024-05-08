<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Concerns\Response;
use App\Http\Requests\Api\V1\Auth\ProfilePicUploadRequest;
use App\Http\Services\Api\V1\Auth\AuthService;
use App\Models\User;
use JustSteveKing\StatusCode\Http;

final class ProfilePictureUpload
{
    use Response;

    public function __construct(
        protected AuthService $authService
    ) {
    }

    public function __invoke(ProfilePicUploadRequest $request, User $user)
    {

        if ($request->has('avatar')) {
            $file = $request->file('avatar');
            $fileName = time().'.'.$file->getClientOriginalName();
            $path = $file->storeAs('uploads/avatar', $fileName, 'public');

            if ($this->authService->updateProfilePic(profile_pic: $path, user: $user)) {
                return Response::successResponse(
                    data: [
                        'message' => 'Avatar updated successfully.',

                    ], status: Http::ACCEPTED()
                );
            }
        }

        return Response::errorResponse(
            data: [
                'message' => 'Something went wrong.',

            ], status: Http::NOT_IMPLEMENTED()
        );
    }
}
