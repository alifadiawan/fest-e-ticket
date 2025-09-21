<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenModel extends Model
{
    protected $table = 'tokens';
    protected $keyType = 'string';
    public $incrementing = false;

    public function event()
    {
        return $this->belongsTo(EventModel::class, 'event_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
