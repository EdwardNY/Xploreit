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

    public function forumTopics()
    {
        return $this->hasMany(ForumTopic::class);
    }

    use HasFactory;
}
