<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends BaseRepository
{

    protected $fieldsSearchable = [
        'name',
        'last_name',
        'mobile_no',
        'email',
        'password',
        'role',
        'colingual',
        'login_by',
    ];
    public function getFieldsSearchable()
    {
        return $this->fieldsSearchable;
    }

    public function model()
    {
        return User::class;
    }
}
