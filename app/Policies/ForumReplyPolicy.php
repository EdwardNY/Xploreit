<?php

namespace App\Policies;

use App\Models\ForumReply;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumReplyPolicy
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
     * @param  \App\Models\ForumReply  $forumReply
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ForumReply $forumReply)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, ForumReply $forumReply = null, $topicId = null)
    {
        if ($topicId) {
            $topic = \App\Models\ForumTopic::findOrFail($topicId);
            if ($topic->is_locked) {
                return false;
            }
        } elseif ($forumReply) {
            if ($forumReply->topic->is_locked) {
                return false;
            }
        }

        if ($topicId) {
            $topic = \App\Models\ForumTopic::findOrFail($topicId);
            $courseId = $topic->course_id;
        } elseif ($forumReply) {
            $courseId = $forumReply->topic->course_id;
        } else {
            return false;
        }

        $course = \App\Models\Course::findOrFail($courseId);

        if ($course->lecturer_id === $user->id) {
            return true;
        }

        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ForumReply  $forumReply
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ForumReply $forumReply)
    {
        if ($forumReply->topic->is_locked) {
            return false;
        }


        return $user->id === $forumReply->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ForumReply  $forumReply
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ForumReply $forumReply)
    {
        return $user->id === $forumReply->user_id ||
        $user->id === $forumReply->topic->user_id ||
        $user->id === $forumReply->topic->course->lecturer_id;

    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ForumReply  $forumReply
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ForumReply $forumReply)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ForumReply  $forumReply
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ForumReply $forumReply)
    {
        //
    }

    public function markAsSolution(User $user, ForumReply $forumReply)
    {
        // Only topic author or course lecturer can mark as solution
        return $user->id === $forumReply->topic->user_id ||
               $user->id === $forumReply->topic->course->lecturer_id;
    }
}
