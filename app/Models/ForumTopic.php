<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumTopic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id',
        'course_id',
        'is_pinned',
        'is_locked'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function replies(){
        return $this->hasMany(ForumReply::class);
    }

    public function rootReplies(){
        return $this->hasMany(ForumReply::class)->whereNull('parent_id');
    }

}
