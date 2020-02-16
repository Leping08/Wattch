<?php

namespace App\Policies;

use App\Models\HttpResponse;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HttpResponsePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any http responses.
     *
     * @param  User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the http response.
     *
     * @param  User  $user
     * @param  HttpResponse  $httpResponse
     * @return mixed
     */
    public function view(User $user, HttpResponse $httpResponse)
    {
        return $user->id === $httpResponse->page->website->user_id;
    }

    /**
     * Determine whether the user can create http responses.
     *
     * @param  User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the http response.
     *
     * @param  User  $user
     * @param  HttpResponse  $httpResponse
     * @return mixed
     */
    public function update(User $user, HttpResponse $httpResponse)
    {
        return $user->id === $httpResponse->page->website->user_id;
    }

    /**
     * Determine whether the user can delete the http response.
     *
     * @param  User  $user
     * @param  HttpResponse  $httpResponse
     * @return mixed
     */
    public function delete(User $user, HttpResponse $httpResponse)
    {
        return $user->id === $httpResponse->page->website->user_id;
    }

    /**
     * Determine whether the user can restore the http response.
     *
     * @param  User  $user
     * @param  HttpResponse  $httpResponse
     * @return mixed
     */
    public function restore(User $user, HttpResponse $httpResponse)
    {
        return $user->id === $httpResponse->page->website->user_id;
    }

    /**
     * Determine whether the user can permanently delete the http response.
     *
     * @param  User  $user
     * @param  HttpResponse  $httpResponse
     * @return mixed
     */
    public function forceDelete(User $user, HttpResponse $httpResponse)
    {
        return $user->id === $httpResponse->page->website->user_id;
    }
}
