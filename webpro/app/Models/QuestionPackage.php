<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionPackage extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'type', 'time'];

    public function questions()
    {
        return $this->hasMany(Question::class, 'package_id');
    }
}
