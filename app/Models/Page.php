<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Page extends Model { use SoftDeletes; protected $guarded = []; protected $casts = ['show_in_nav' => 'boolean']; }
