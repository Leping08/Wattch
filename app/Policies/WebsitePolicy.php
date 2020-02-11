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
     * @param  User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the website.
     *
     * @param  User  $user
     * @param  Website  $website
     * @return mixed
     */
    public function view(User $user, Website $website)
    {
        return $user->id === $website->user_id;
    }

    /**
     * Determine whether the user can create websites.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //return $user->subscription->product->features->rules->limit > $user->websites->count()
        // TODO add logic to make sure they have not hit the website limit
    }

    /**
     * Determine whether the user can update the website.
     *
     * @param  User  $user
     * @param  Website  $website
     * @return mixed
     */
    public function update(User $user, Website $website)
    {
        return $user->id === $website->user_id;
    }

    /**
     * Determine whether the user can delete the website.
     *
     * @param  User  $user
     * @param  Website  $website
     * @return mixed
     */
    public function delete(User $user, Website $website)
    {
        return $user->id === $website->user_id;
    }

    /**
     * Determine whether the user can restore the website.
     *
     * @param  User  $user
     * @param  Website  $website
     * @return mixed
     */
    public function restore(User $user, Website $website)
    {
        return $user->id === $website->user_id;
    }

    /**
     * Determine whether the user can permanently delete the website.
     *
     * @param  User  $user
     * @param  Website  $website
     * @return mixed
     */
    public function forceDelete(User $user, Website $website)
    {
        return $user->id === $website->user_id;
    }
}
