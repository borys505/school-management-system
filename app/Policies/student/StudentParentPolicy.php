<?php

namespace App\Policies\Student;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentParentPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can search student parent
     *
     * @param  \App\User  $user
     * @param  \App\Models\Student\StudentParent  $student_parent
     * @return mixed
     */
    public function search(User $user)
    {
        return $user->can('new-registration');
    }
}
