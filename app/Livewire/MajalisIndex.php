<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Majlis;
use Livewire\WithPagination;

class MajalisIndex extends Component
{
    use WithPagination;

    // المتغير الذي سيرتبط بحقل البحث
    public $search = '';

    // تصفير أرقام الصفحات عند كتابة أي كلمة جديدة في البحث
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $majalis = Majlis::where('is_published', true)
            ->when($this->search, function ($query) {
                $query->where(function ($subQuery) {
                    // البحث في عنوان المجلس
                    $subQuery->where('title', 'like', '%' . $this->search . '%')
                        // أو البحث في وصف المجلس
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        // أو البحث في اسم السورة المرتبطة بالمجلس
                        ->orWhereHas('ayat', function ($ayahQuery) {
                            $ayahQuery->where('surah_name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->latest()
            ->paginate(9); // عرض 9 مجالس في كل صفحة

        return view('livewire.majlis-index', [
            'majalis' => $majalis
        ])->layout('layouts.app'); // تأكد من وجود هذه السلسلة لعرض الهيدر والتصميم العام
    }
}