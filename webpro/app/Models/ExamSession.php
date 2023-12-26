<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSession extends Model
{
    protected $fillable = ['question_package_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function questionPackage()
    {
        return $this->belongsTo(QuestionPackage::class);
    }

    public function answers()
    {
        return $this->hasMany(StudentAnswer::class);
    }
}
