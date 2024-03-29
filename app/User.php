<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */


    public function exams()
    {
        return $this->hasMany(Exam::class, 'creator_id');
    }

    public function questionBanks()
    {
        return $this->hasMany(QuestionBank::class, 'instructor_id');
    }

    public function studentAnswers()
    {
        return $this->hasMany(StudentAnswer::class, 'student_id');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'publisher_id');
    }

    #polymorphic relationships
    public function image()
    {
        return $this->morphOne('App\Image', 'imageable');
    }

    #many to many relationships
    public function examsSubmitted()
    {
        return $this->belongsToMany('App\Exam', 'submit_exam', 'student_id', 'exam_id');
    }

    public function assignedModels()
    {
        return $this->belongsToMany('App\examModels', 'assign_model', 'student_id', 'model_id');
    }

    public function examsAssigned()
    {
        return $this->belongsToMany('App\examModels', 'assign_exam', 'student_id', 'model_id');
    }

    public function courses()
    {
        return $this->belongsToMany('App\Course', 'user_course');
    }
}
