<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table="quizzes";

    protected $with = ['language'];

    protected $fillable = [
        'language_id',
        'question1',
        'option1A',
        'option1B',
        'option1C',
        'option1D',
        'answer1',
        'question2',
        'option2A',
        'option2B',
        'option2C',
        'option2D',
        'answer2',
        'question3',
        'option3A',
        'option3B',
        'option3C',
        'option3D',
        'answer3',
        'question4',
        'option4A',
        'option4B',
        'option4C',
        'option4D',
        'answer4',
        'question5',
        'option5A',
        'option5B',
        'option5C',
        'option5D',
        'answer5',
    ];

    public function language(){
        return $this->belongsTo(Language::class);
    }
}
