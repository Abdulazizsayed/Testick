<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'content', 'is_correct', 'question_id'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
