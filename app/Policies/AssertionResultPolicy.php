<?php

namespace App\Policies;

use App\AssertionResult;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssertionResultPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any assertion results.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the assertion result.
     *
     * @param  \App\User  $user
     * @param  \App\AssertionResult  $assertionResult
     * @return mixed
     */
    public function view(User $user, AssertionResult $assertionResult)
    {
        return $user->id === $assertionResult->assertion->page->website->user_id;
    }

    /**
     * Determine whether the user can create assertion results.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the assertion result.
     *
     * @param  \App\User  $user
     * @param  \App\AssertionResult  $assertionResult
     * @return mixed
     */
    public function update(User $user, AssertionResult $assertionResult)
    {
        return $user->id === $assertionResult->assertion->page->website->user_id;
    }

    /**
     * Determine whether the user can delete the assertion result.
     *
     * @param  \App\User  $user
     * @param  \App\AssertionResult  $assertionResult
     * @return mixed
     */
    public function delete(User $user, AssertionResult $assertionResult)
    {
        return $user->id === $assertionResult->assertion->page->website->user_id;
    }

    /**
     * Determine whether the user can restore the assertion result.
     *
     * @param  \App\User  $user
     * @param  \App\AssertionResult  $assertionResult
     * @return mixed
     */
    public function restore(User $user, AssertionResult $assertionResult)
    {
        return $user->id === $assertionResult->assertion->page->website->user_id;
    }

    /**
     * Determine whether the user can permanently delete the assertion result.
     *
     * @param  \App\User  $user
     * @param  \App\AssertionResult  $assertionResult
     * @return mixed
     */
    public function forceDelete(User $user, AssertionResult $assertionResult)
    {
        return $user->id === $assertionResult->assertion->page->website->user_id;
    }
}
