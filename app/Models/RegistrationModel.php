<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationModel extends Model
{
    protected $table = "registrations";
    protected $guarded = [];

    public function event()
    {
        return $this->belongsTo(EventModel::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function token()
    {
        return $this->belongsTo(TokenModel::class, 'token_id', 'id');
    }
}
