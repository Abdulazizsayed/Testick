<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = [
        'title', 'type', 'date', 'duration', 'allow_period', 'course_id', 'creator_id'
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function studentAnswers()
    {
        return $this->hasMany(StudentAnswer::class);
    }

    #many to many relationships
    public function students_submitted()
    {
        return $this->belongsToMany('App\User', 'submit_exam', 'student_id', 'exam_id');
    }

    public function questions()
    {
        return $this->belongsToMany('App\Question');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function students_assigned()
    {
        return $this->belongsToMany('App\User', 'assign_exam', 'student_id', 'exam_id');
    }
}
