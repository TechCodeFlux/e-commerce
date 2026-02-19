<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Microsite extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'image',
        'club_id',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'status'     => 'boolean',
    ];

    /**
     * Relationship: Microsite belongs to Club
     */
    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
