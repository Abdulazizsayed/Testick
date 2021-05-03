<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionBank extends Model
{
    protected $fillable = [
        'title', 'instructor_id', 'subject_id'
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function instructor(){
        return $this->belongsTo(User::class, 'instructor_id');
    }
}
