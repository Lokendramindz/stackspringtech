<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentRevision extends Model
{
    protected $guarded = [];

    protected $casts = ['snapshot' => 'array'];
}
