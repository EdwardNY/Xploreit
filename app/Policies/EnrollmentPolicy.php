<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnrollmentPolicy
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
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Enrollment $enrollment)
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
        if ($user->role !== 'student') {
            return false;
        }
        
        // Can't enroll in your own course
        if ($course->lecturer_id === $user->id) {
            return false;
        }
        
        // Can't enroll in an unpublished course
        if (!$course->is_published) {
            return false;
        }
        
        // Can't enroll if already enrolled
        return !$course->isUserEnrolled($user->id);

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Enrollment $enrollment)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Enrollment $enrollment)
    {
        return $user->id === $enrollment->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Enrollment $enrollment)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Enrollment  $enrollment
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Enrollment $enrollment)
    {
        //
    }

    public function viewEnrolledStudents(User $user, Course $course)
    {
        // Only the course lecturer can view the list of enrolled students
        return $user->id === $course->lecturer_id;
    }
}
