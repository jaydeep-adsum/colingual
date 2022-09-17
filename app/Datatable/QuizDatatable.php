<?php

namespace App\Datatable;

use App\Models\Quiz;

class QuizDatatable
{
    /**
     * @param array $input
     * @return Quiz
     */
    public function get($input = [])
    {
        /** @var Quiz $query */
        $query = Quiz::query()->select('quizzes.*');

        return $query;
    }
}
