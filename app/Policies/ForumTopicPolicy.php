<?php

namespace App\Policies;

use App\Models\ForumTopic;
use App\Models\User;
use App\Models\Course;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumTopicPolicy
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
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ForumTopic  $forumTopic
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ForumTopic $forumTopic)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if ($course->lecturer_id === $user->id) {
            return true;
        }
        
        return $user->enrollments()->where('course_id', $course->id)->exists();
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ForumTopic  $forumTopic
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ForumTopic $forumTopic)
    {
        return $user->id === $forumTopic->user_id || $user->id === $forumTopic->course->lecturer_id;

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ForumTopic  $forumTopic
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ForumTopic $forumTopic)
    {
        return $user->id === $forumTopic->user_id || $user->id === $forumTopic->course->lecturer_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ForumTopic  $forumTopic
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ForumTopic $forumTopic)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ForumTopic  $forumTopic
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ForumTopic $forumTopic)
    {
        //
    }

    public function pin(User $user, ForumTopic $forumTopic)
    {
        return $user->id === $forumTopic->course->lecturer_id;
    }

    public function lock(User $user, ForumTopic $forumTopic)
    {
        return $user->id === $forumTopic->course->lecturer_id;
    }

}
