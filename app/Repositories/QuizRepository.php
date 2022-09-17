<?php

namespace App\Repositories;

use App\Models\Quiz;

class QuizRepository extends BaseRepository
{

    protected $fieldsSearchable = [
        'language_id',
        'question',
        'A',
        'B',
        'C',
        'D',
        'answer',
    ];
    public function getFieldsSearchable()
    {
        return $this->fieldsSearchable;
    }

    public function model()
    {
        return Quiz::class;
    }
}
