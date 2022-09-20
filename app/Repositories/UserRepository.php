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
        'country_code',
        'role',
        'colingual',
        'translator',
        'image_url',
        'primary_language',
        'languages',
        'login_by',
        'card_number',
        'exp_date',
        'cvv',
        'country',
        'nickname',
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
