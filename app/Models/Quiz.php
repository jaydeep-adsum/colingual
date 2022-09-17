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
        'question',
        'A',
        'B',
        'C',
        'D',
        'answer',
    ];

    public function language(){
        return $this->belongsTo(Language::class);
    }
}
