<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForumReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'user_id',
        'forum_topic_id',
        'parent_id',
        'is_solution'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function topic(){
        return $this->belongsTo(ForumTopic::class, 'forum_topic_id');
    }

    public function parent(){
        return $this->belongsTo(ForumReply::class, 'parent_id');
    }
    
    public function childReplies(){
        return $this->hasMany(ForumReply::class, 'parent_id');
    }

}
