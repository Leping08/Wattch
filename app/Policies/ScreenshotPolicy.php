<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Screenshot;
use Illuminate\Auth\Access\HandlesAuthorization;

class ScreenshotPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any screenshots.
     *
     * @param  User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the screenshot.
     *
     * @param  User  $user
     * @param  Screenshot  $screenshot
     * @return mixed
     */
    public function view(User $user, Screenshot $screenshot)
    {
        return $user->id === $screenshot->page->website->user_id;
    }

    /**
     * Determine whether the user can create screenshots.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the screenshot.
     *
     * @param  User  $user
     * @param  Screenshot  $screenshot
     * @return mixed
     */
    public function update(User $user, Screenshot $screenshot)
    {
        return $user->id === $screenshot->page->website->user_id;
    }

    /**
     * Determine whether the user can delete the screenshot.
     *
     * @param  User  $user
     * @param  Screenshot  $screenshot
     * @return mixed
     */
    public function delete(User $user, Screenshot $screenshot)
    {
        return $user->id === $screenshot->page->website->user_id;
    }

    /**
     * Determine whether the user can restore the screenshot.
     *
     * @param  User  $user
     * @param  Screenshot  $screenshot
     * @return mixed
     */
    public function restore(User $user, Screenshot $screenshot)
    {
        return $user->id === $screenshot->page->website->user_id;
    }

    /**
     * Determine whether the user can permanently delete the screenshot.
     *
     * @param  User  $user
     * @param  Screenshot  $screenshot
     * @return mixed
     */
    public function forceDelete(User $user, Screenshot $screenshot)
    {
        return $user->id === $screenshot->page->website->user_id;
    }
}
