<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'title', 
        'description', 
        'lecturer_id', 
        'thumbnail', 
        'is_published'
    ];

    // Relationships
    public function lecturer()
    {
        return $this->belongsTo(User::class, 'lecturer_id');
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function enrolledStudents()
    {
        return $this->belongsToMany(User::class, 'enrollments')
            ->withTimestamp('enrolled_at')
            ->withTimestamps();
    }

    public function isUserEnrolled($userId)
    {
        return $this->enrollments()->where('user_id', $userId)->exists();
    }

    public function forumTopics()
    {
        return $this->hasMany(ForumTopic::class);
    }

    use HasFactory;
}
