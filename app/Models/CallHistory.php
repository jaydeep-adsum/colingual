<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CallHistory extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table="call_histories";

    /**
     * @var string[]
     */
    protected $with = ['call_user','user'];

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'call_user_id',
        'duration',
        'call_type',
        'tip',
    ];

    /**
     * @return BelongsTo
     */
    public function call_user(){
        return $this->belongsTo(User::class,'call_user_id');
    }

    /**
     * @return BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
