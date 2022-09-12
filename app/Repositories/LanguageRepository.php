<?php

namespace App\Repositories;

use App\Models\Languages;

class LanguageRepository extends BaseRepository
{

    protected $fieldsSearchable = [
        'language',
    ];
    public function getFieldsSearchable()
    {
        return $this->fieldsSearchable;
    }

    public function model()
    {
        return Languages::class;
    }
}
