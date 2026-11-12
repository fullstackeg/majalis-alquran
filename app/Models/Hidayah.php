<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Hidayah extends Model
{
    protected $table = 'hidayat';

    // تحديد الأعمدة المسموح بالحشو الجماعي لضمان عدم حدوث أي خطأ مع أعمدة الجدول مثل votes_count
    protected $fillable = [
        'user_id',
        'majlis_id',
        'content',
        'status',
        'votes_count',
    ];

    public function majlis(): BelongsTo
    {
        return $this->belongsTo(Majlis::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
