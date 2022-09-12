<?php

namespace App\Datatable;

use App\Models\Languages;

class LanguageDatatable
{
    /**
     * @param array $input
     * @return Languages
     */
    public function get($input = [])
    {
        /** @var Languages $query */
        $query = Languages::query()->select('languages.*');

        return $query;
    }
}
