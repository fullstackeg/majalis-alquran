<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Majlis extends Model
{
    protected $table = 'majalis';

    // تحديد الأعمدة المسموح بالحشو الجماعي لضمان الأمان وتوافق الأعمدة مثل user_id و slug
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'description',
    ];

    // العلاقة مع المشرف (المنشئ) لحل خطأ [user] نهائياً
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

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

    // الهدايات المقبولة للعامة
    public function hidayat()
    {
        return $this->hasMany(Hidayah::class)->where('status', 'approved')->latest();
    }

    // جميع الهدايات (للمشرف لو أردت إدارتها لاحقاً)
    public function allHidayat()
    {
        return $this->hasMany(Hidayah::class);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
