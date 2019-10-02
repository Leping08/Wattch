<?php

namespace App\Policies;

use App\User;
use App\Website;
use Illuminate\Auth\Access\HandlesAuthorization;

class WebsitePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any websites.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the website.
     *
     * @param  \App\User  $user
     * @param  \App\Website  $website
     * @return mixed
     */
    public function view(User $user, Website $website)
    {
        return $user->id === $website->user_id;
    }

    /**
     * Determine whether the user can create websites.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // TODO add logic to make sure they have not hit the website limit
    }

    /**
     * Determine whether the user can update the website.
     *
     * @param  \App\User  $user
     * @param  \App\Website  $website
     * @return mixed
     */
    public function update(User $user, Website $website)
    {
        return $user->id === $website->user_id;
    }

    /**
     * Determine whether the user can delete the website.
     *
     * @param  \App\User  $user
     * @param  \App\Website  $website
     * @return mixed
     */
    public function delete(User $user, Website $website)
    {
        return $user->id === $website->user_id;
    }

    /**
     * Determine whether the user can restore the website.
     *
     * @param  \App\User  $user
     * @param  \App\Website  $website
     * @return mixed
     */
    public function restore(User $user, Website $website)
    {
        return $user->id === $website->user_id;
    }

    /**
     * Determine whether the user can permanently delete the website.
     *
     * @param  \App\User  $user
     * @param  \App\Website  $website
     * @return mixed
     */
    public function forceDelete(User $user, Website $website)
    {
        return $user->id === $website->user_id;
    }
}
