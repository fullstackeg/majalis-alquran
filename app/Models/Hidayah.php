<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hidayah extends Model
{
    protected $table = 'hidayat';
    
    protected $guarded = [];

    public function majlis(): BelongsTo
    {
        return $this->belongsTo(Majlis::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
