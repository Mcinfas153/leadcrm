<?php

namespace App\Policies;

use App\Models\LeadEntry;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeadEntryPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeadEntry  $leadEntry
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, LeadEntry $leadEntry)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeadEntry  $leadEntry
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, LeadEntry $leadEntry)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeadEntry  $leadEntry
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, LeadEntry $leadEntry)
    {
        return $user->id == $leadEntry->user_id || $user->user_type != config('custom.USER_NORMAL');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeadEntry  $leadEntry
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, LeadEntry $leadEntry)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\LeadEntry  $leadEntry
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, LeadEntry $leadEntry)
    {
        //
    }

    public function massDelete(User $user)
    {
        return $user->user_type != config('custom.USER_NORMAL');
    }
}
