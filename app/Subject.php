<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name'
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function questionBanks()
    {
        return $this->hasMany(QuestionBank::class, 'question_bank_id');
    }
}
