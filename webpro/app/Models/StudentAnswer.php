<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    protected $fillable = ['exam_session_id', 'question_id', 'selected_option'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
