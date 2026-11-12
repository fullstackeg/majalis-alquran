<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Majlis extends Model
{
    protected $table = 'majalis';
    
    protected $guarded = [];

    // المجلس يحتوي على عدة مقاطع/آيات
    public function ayat(): HasMany
    {
        return $this->hasMany(Ayah::class);
    }

    // المجلس يحتوي على عدة تدبرات من القراء
    public function tadabburat(): HasMany
    {
        return $this->hasMany(Tadabbur::class);
    }

    // المجلس يحتوي على عدة هدايات وسلوكيات عملية
    public function hidayat(): HasMany
    {
        return $this->hasMany(Hidayah::class);
    }
}
