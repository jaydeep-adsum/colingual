<?php

namespace App\Repositories;

use App\Models\CallHistory;

class CallHistoryRepository extends BaseRepository
{

    protected $fieldsSearchable = [
        'user_id',
        'call_user_id',
        'duration',
        'call_type',
        'tip',
    ];
    public function getFieldsSearchable()
    {
        return $this->fieldsSearchable;
    }

    public function model()
    {
        return CallHistory::class;
    }
}
