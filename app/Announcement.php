<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title', 'content', 'publisher_id', 'course_id'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
