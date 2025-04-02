<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 
        'description', 
        'course_id', 
        'video_path', 
        'duration', 
        'order', 
        'is_preview'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

}
