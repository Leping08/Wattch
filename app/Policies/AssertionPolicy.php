<?php

namespace App\Policies;

use App\Assertion;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssertionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any assertions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the assertion.
     *
     * @param  \App\User  $user
     * @param  \App\Assertion  $assertion
     * @return mixed
     */
    public function view(User $user, Assertion $assertion)
    {
        return $user->id === $assertion->page->website->user_id;
    }

    /**
     * Determine whether the user can create assertions.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the assertion.
     *
     * @param  \App\User  $user
     * @param  \App\Assertion  $assertion
     * @return mixed
     */
    public function update(User $user, Assertion $assertion)
    {
        return $user->id === $assertion->page->website->user_id;
    }

    /**
     * Determine whether the user can delete the assertion.
     *
     * @param  \App\User  $user
     * @param  \App\Assertion  $assertion
     * @return mixed
     */
    public function delete(User $user, Assertion $assertion)
    {
        return $user->id === $assertion->page->website->user_id;
    }

    /**
     * Determine whether the user can restore the assertion.
     *
     * @param  \App\User  $user
     * @param  \App\Assertion  $assertion
     * @return mixed
     */
    public function restore(User $user, Assertion $assertion)
    {
        return $user->id === $assertion->page->website->user_id;
    }

    /**
     * Determine whether the user can permanently delete the assertion.
     *
     * @param  \App\User  $user
     * @param  \App\Assertion  $assertion
     * @return mixed
     */
    public function forceDelete(User $user, Assertion $assertion)
    {
        return $user->id === $assertion->page->website->user_id;
    }
}