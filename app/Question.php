<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'content', 'type', 'chapter', 'parent_id', 'question_bank_id','difficulty'
    ];

    public function questionBank()
    {
        return $this->belongsTo(QuestionBank::class, 'question_bank_id');
    }

    public function parent()
    {
        return $this->belongsTo(Question::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Question::class, 'parent_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function studentAnswers()
    {
        return $this->hasMany(StudentAnswer::class);
    }

    #many to many relationships
    public function exams()
    {
        return $this->belongsToMany('App\Exam');
    }
}
