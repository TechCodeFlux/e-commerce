<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Microsite extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_id',
        'event_name',
        'description',
        'banner',
        'start_date',
        'end_date',
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
