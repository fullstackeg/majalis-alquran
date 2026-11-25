<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Majlis extends Model
{
    protected $table = 'majalis';

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Majlis $majlis) {
            if (empty($majlis->slug)) {
                $base = Str::slug($majlis->title, '-', null) ?: 'majlis';
                $majlis->slug = $base . '-' . Str::lower(Str::random(5));
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ayat(): HasMany
    {
        return $this->hasMany(Ayah::class);
    }

    public function tadabburat(): HasMany
    {
        return $this->hasMany(Tadabbur::class);
    }

    public function hidayat()
    {
        return $this->hasMany(Hidayah::class)->where('status', 'approved')->latest();
    }

    public function allHidayat()
    {
        return $this->hasMany(Hidayah::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
