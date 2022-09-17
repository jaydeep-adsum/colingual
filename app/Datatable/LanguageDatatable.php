<?php

namespace App\Datatable;

use App\Models\Language;

class LanguageDatatable
{
    /**
     * @param array $input
     * @return Languages
     */
    public function get($input = [])
    {
        /** @var Languages $query */
        $query = Language::query()->select('languages.*');

        return $query;
    }
}
