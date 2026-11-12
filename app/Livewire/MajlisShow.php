<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Majlis;
use App\Models\Tadabbur;
use Illuminate\Support\Facades\Auth;
use App\Models\TadabburLike;

class MajlisShow extends Component
{
    public Majlis $majlis;
    public $content = '';

    protected $rules = [
        'content' => 'required|min:10|max:1000',
    ];

    public function mount(Majlis $majlis)
    {
        // التحميل المسبق للعلاقات مع الإعجابات لحل مشكلة (N+1)
        $this->majlis = $majlis->load([
            'ayat',
            'tadabburat' => fn($q) => $q->where('status', 'approved')->latest(),
            'tadabburat.user',
            'tadabburat.likes', // تمت إضافة تحميل الإعجابات هنا
            'hidayat' => fn($q) => $q->where('status', 'approved')->latest(),
            'hidayat.user',
        ]);
    }

    public function storeTadabbur()
    {
        // حماية إضافية في الباك-إند لمنع غير المسجلين
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->validate();

        Tadabbur::create([
            'user_id' => Auth::id(),
            'majlis_id' => $this->majlis->id,
            'content' => $this->content,
            'status' => 'pending',
        ]);

        $this->content = '';

        session()->flash('message', 'جزاك الله خيراً! تم إرسال تدبرك بنجاح وسيظهر للعامة بعد مراجعته.');

        // تحديث الكائن في الذاكرة وإعادة تحميل العلاقات
        $this->mount($this->majlis->refresh());
    }

    public function toggleLike($tadabburId)
    {
        // حماية الإعجاب أيضاً لغير المسجلين
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();

        $existingLike = TadabburLike::where('user_id', $userId)
            ->where('tadabbur_id', $tadabburId)
            ->first();

        if ($existingLike) {
            $existingLike->delete();
        } else {
            TadabburLike::create([
                'user_id' => $userId,
                'tadabbur_id' => $tadabburId,
            ]);
        }

        // تحديث الكائن وإعادة تحميل العلاقات لكي يظهر القلب أحمر فوراً
        $this->mount($this->majlis->refresh());
    }

    public function render()
    {
        return view('livewire.majlis-show');
    }
}