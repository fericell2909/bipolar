<?php

namespace App\Policies;

use App\Models\Buy;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BuyPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Buy $buy)
    {
        return (int)$buy->user_id === $user->id;
    }

    public function destroy(User $user, Buy $buy)
    {
        return (int)$buy->user_id === $user->id;
    }
}
