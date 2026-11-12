<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ayah extends Model
{
    protected $table = 'ayat';

    protected $fillable = [
        'majlis_id',
        'surah_name',
        'from_ayah',
        'to_ayah',
        'quranic_text',
        'bayan_text',
    ];

    // الآيات تنتمي إلى مجلس معين
    public function majlis(): BelongsTo
    {
        return $this->belongsTo(Majlis::class);
    }
}