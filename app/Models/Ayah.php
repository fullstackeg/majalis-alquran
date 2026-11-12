<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ayah extends Model
{
    protected $table = 'ayat';
    
    protected $guarded = [];

    // الآيات تنتمي إلى مجلس معين
    public function majlis(): BelongsTo
    {
        return $this->belongsTo(Majlis::class);
    }
}