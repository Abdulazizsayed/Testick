<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class examModels extends Model
{
    protected $fillable = [
        'exam_id'
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function questions()
    {
        return $this->belongsToMany('App\Question');
    }

    public function studentsAssigned()
    {
        return $this->belongsToMany('App\User', 'assign_model', 'model_id', 'student_id');
    }
}
