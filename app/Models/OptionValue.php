<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OptionValue extends Model
{
    use SoftDeletes;
    protected $fillable = 
    [
        'name',
        'option_value_id',
        'status'
    ];
}
