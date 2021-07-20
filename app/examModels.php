<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class examModels extends Model
{
    protected $fillable = [
       'exam_id'
     ];

    public function creator()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }
    public function questions()
    {
        return $this->belongsToMany('App\Question');
    }
    public function students_assigned()
    {
        return $this->belongsToMany('App\User', 'assign_exam', 'student_id', 'model_id');
    }
}
