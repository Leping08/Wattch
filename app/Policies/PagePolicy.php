<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any pages.
     *
     * @param  User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the page.
     *
     * @param  User  $user
     * @param  Page  $page
     * @return mixed
     */
    public function view(User $user, Page $page)
    {
        return $user->id === $page->website->user_id;
    }

    /**
     * Determine whether the user can create pages.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the page.
     *
     * @param  User  $user
     * @param  Page  $page
     * @return mixed
     */
    public function update(User $user, Page $page)
    {
        return $user->id === $page->website->user_id;
    }

    /**
     * Determine whether the user can delete the page.
     *
     * @param  User  $user
     * @param  Page  $page
     * @return mixed
     */
    public function delete(User $user, Page $page)
    {
        return $user->id === $page->website->user_id;
    }

    /**
     * Determine whether the user can restore the page.
     *
     * @param  User  $user
     * @param  Page  $page
     * @return mixed
     */
    public function restore(User $user, Page $page)
    {
        return $user->id === $page->website->user_id;
    }

    /**
     * Determine whether the user can permanently delete the page.
     *
     * @param  User  $user
     * @param  Page  $page
     * @return mixed
     */
    public function forceDelete(User $user, Page $page)
    {
        return $user->id === $page->website->user_id;
    }
}
