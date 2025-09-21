<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class EventModel extends Model
{
    protected $table = 'events';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    const DRAFT     = 'draft';
    const PUBLISHED = 'published';
    const ARCHIVED  = 'archived';
    const UPCOMING  = 'upcoming';
    const PASSED  = 'passed';


    protected static function boot()
    {
        parent::boot();

        // Generate UUID for primary key
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }

            // Generate slug from name if not provided
            if (empty($model->slug) && !empty($model->name)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function tokenBatches()
    {
        return $this->hasMany(TokenBatchModel::class, 'event_id', 'id');
    }

    public function tokens()
    {
        return $this->hasMany(TokenModel::class, 'event_id', 'id');
    }
}
