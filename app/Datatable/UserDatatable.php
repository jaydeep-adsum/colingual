<?php

namespace App\Datatable;

use App\Models\User;

class UserDatatable
{
    /**
     * @param array $input
     * @return User
     */
    public function get($input = [])
    {
        /** @var User $query */
        $query = User::query()->select('users.*');
        $query->where('role','0');

        return $query;
    }
}
