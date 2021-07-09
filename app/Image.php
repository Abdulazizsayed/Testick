<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['url', 'imageable_type', 'imageable_id'];
    protected $table = 'imageable';

    public function imageable()
    {
        return $this->morphTo();
    }
}
