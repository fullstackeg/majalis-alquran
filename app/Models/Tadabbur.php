<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tadabbur extends Model
{
    protected $table = 'tadabburat';
    
    protected $guarded = [];

    // التدبر يتبع مجلساً محددماً
    public function majlis(): BelongsTo
    {
        return $this->belongsTo(Majlis::class);
    }

    // التدبر كتبه مستخدم معين
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // علاقة الإعجابات الجديدة
    public function likes(): HasMany
    {
        return $this->hasMany(TadabburLike::class);
    }
}
