<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['package_id', 'number', 'text'];

    public function package()
    {
        return $this->belongsTo(QuestionPackage::class, 'package_id');
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function correctAnswer()
    {
        return $this->hasOne(Answer::class)->where('is_correct', true);
    }
}



