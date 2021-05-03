<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'level', 'semester', 'is_done', 'code', 'subject_id'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    #polymorphic relationships
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
