<?php

namespace App\Repositories;

use App\Models\Language;

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
        return Language::class;
    }
}
