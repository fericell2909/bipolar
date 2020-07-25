<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Str;

class SocialNetworkService
{
    public function getOrCreateFromFacebook($userFacebookData, $image)
    {
        $user = User::whereFacebookId($userFacebookData['id'])
            ->whereEmail($userFacebookData['email'])
            ->first();

        $userPhoto = $image['data']['url'] ?? null;

        if ($user) {
            return $user;
        } else {
            $user = User::whereEmail($userFacebookData['email'])->first();

            if ($user) {
                $user->facebook_id = $userFacebookData['id'];
                $user->save();
            } else {
                $user = new User;
                $user->email = $userFacebookData['email'];
                $user->name = $userFacebookData['first_name'] ?? null;
                $user->lastname = $userFacebookData['last_name'] ?? null;
                $user->password = bcrypt(Str::random(16));
                $user->active = date('Y-m-d H:i:s');
                $user->save();
            }

            return $user;
        }
    }
}
