<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenBatchModel extends Model
{
    protected $table = 'token_batches';
    protected $keyType = 'string';   
    public $incrementing = false;   

    public function event()
    {
        return $this->belongsTo(EventModel::class, 'event_id', 'id');
    }
}
