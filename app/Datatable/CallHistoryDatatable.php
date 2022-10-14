<?php

namespace App\Datatable;

use App\Models\CallHistory;

class CallHistoryDatatable
{
    /**
     * @param array $input
     * @return CallHistory
     */
    public function get($input = [])
    {
        /** @var CallHistory $query */
        $query = CallHistory::query()->select('call_histories.*');
        if($input['user']){
            $query->where('user_id',$input['user'])->orWhere('call_user_id',$input['user']);
        }
        if($input['call_type']){
            $query->where('call_type',$input['call_type']);
        }

        return $query;
    }
}
