<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alias extends Model
{
    protected $table = 'aliases';

    /**
     * Get the parent commentable model (post or video).
     */
    public function replaceable()
    {
        return $this->morphTo();
    }
}
