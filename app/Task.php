<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'taskable_type',
        'taskable_id',
        'frequency'
    ];

    public function taskable()
    {
        return $this->morphTo();
    }
}
