<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    public function examModels()
    {
        return $this->hasMany(examModels::class);
    }


    #many to many relationships
    public function studentsSubmitted()
    {
        return $this->belongsToMany('App\User', 'submit_exam', 'exam_id', 'student_id');
    }

    public function studentsEntered()
    {
        return $this->belongsToMany('App\User', 'enter_exam', 'exam_id', 'student_id');
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
        return $this->belongsToMany('App\User', 'assign_exam', 'student_id', 'model_id');
    }

    # Calculated fields
    public function weight()
    {
        if ($this->examModels()->count() > 0) {
            return $this->examModels()->first()->questions()->withPivot('weight')->sum('weight');
        } else {
            return 'Have No models';
        }
    }

    public function maxScore()
    {
        if ($this->studentsSubmitted()->count() > 0) {
            return $this->studentsSubmitted()->withPivot('score')->max('score');
        } else {
            return 0;
        }
    }

    public function minScore()
    {
        if ($this->studentsSubmitted()->count() > 0) {
            return $this->studentsSubmitted()->withPivot('score')->min('score');
        } else {
            return 0;
        }
    }

    public function avgScore()
    {
        if ($this->studentsSubmitted()->count() > 0) {
            return $this->studentsSubmitted()->withPivot('score')->average('score');
        } else {
            return 0;
        }
    }

    public function successPercentage()
    {
        if ($this->studentsSubmitted()->count() > 0) {
            return ($this->studentsSubmitted()->wherePivot('score', '>=', $this->weight() / 2)->count() / $this->studentsSubmitted()->count()) * 100;
        }

        return 0;
    }

    public function chapterAbsorbtion($ch)
    {
        if ($this->questions()->count() > 0) {
            return ($this->questions()->where('chapter', $ch)->get()->map(function ($item) {
                return $item->studentAnswers;
            })->collapse()->where('exam_id', $this->id)->average('score') / $this->questions()->where('chapter', $this->questions()->select('chapter')->distinct()->get()->first()->chapter)->withPivot('weight')->sum('weight')) * 100;
        }

        return 0;
    }
}
