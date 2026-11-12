<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Majlis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MajlisManager extends Component
{
    use WithPagination;

    public $search = '';
    public $majlisId = null;
    public $title = '';
    public $description = '';

    public $isOpen = false;
    public $isEditMode = false;

    public $historyModalOpen = false;
    public $selectedMajlisHistory = [];
    public $selectedMajlisTitle = '';

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ];
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetForm();
        $this->isOpen = true;
        $this->isEditMode = false;
    }

    public function store()
    {
        $this->validate();

        $majlis = Majlis::create([
            'user_id' => auth()->id(),
            'title' => $this->title,
            'slug' => \Illuminate\Support\Str::random(10),
            'description' => $this->description,
        ]);

        // تسجيل حدث الإنشاء في جدول التاريخ
        \DB::table('majlis_histories')->insert([
            'majlis_id' => $majlis->id,
            'user_id' => auth()->id(),
            'action' => 'created',
            'old_content' => null,
            'new_content' => "تم إنشاء المجلس بالعنوان: {$this->title}",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        session()->flash('message', 'تم إنشاء المجلس بنجاح.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $majlis = Majlis::findOrFail($id);
        $this->majlisId = $majlis->id;
        $this->title = $majlis->title;
        $this->description = $majlis->description;

        $this->isOpen = true;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate();

        $majlis = Majlis::findOrFail($this->majlisId);

        // التحقق مما إذا كان هناك أي تغيير حقيقي تم إجراؤه
        if ($majlis->title === $this->title && $majlis->description === $this->description) {
            // إرسال تنبيه للمشرف بأنه لم يتم إجراء أي تعديل
            session()->flash('error', 'لم يتم اكتشاف أي تغييرات على بيانات المجلس، لذا لم يتم حفظ أي تعديل.');
            $this->closeModal();
            return; // إيقاف التنفيذ وعدم حفظ سجل فارغ
        }

        // إذا وُجد تغيير حقيقي، نقوم بتسجيله في جدول التاريخ
        \DB::table('majlis_histories')->insert([
            'majlis_id' => $majlis->id,
            'user_id' => auth()->id(),
            'action' => 'updated',
            'old_content' => "العنوان السابق: {$majlis->title} | الوصف: {$majlis->description}",
            'new_content' => "العنوان الجديد: {$this->title} | الوصف: {$this->description}",
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // تنفيذ التعديل الفعلي
        $majlis->update([
            'title' => $this->title,
            'description' => $this->description,
        ]);

        session()->flash('message', 'تم تحديث المجلس وحفظ سجل التعديل بنجاح.');
        $this->closeModal();
    }

    public function delete($id)
    {
        Majlis::findOrFail($id)->delete();
        session()->flash('message', 'تم حذف المجلس بنجاح.');
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->majlisId = null;
        $this->title = '';
        $this->description = '';
    }

    public function showHistory($id)
    {
        $majlis = Majlis::findOrFail($id);
        $this->selectedMajlisTitle = $majlis->title;

        // جلب سجلات التعديل مرتبة من الأحدث للأقدم مع بيانات المستخدم
        $this->selectedMajlisHistory = \DB::table('majlis_histories')
            ->where('majlis_id', $id)
            ->join('users', 'majlis_histories.user_id', '=', 'users.id')
            ->select('majlis_histories.*', 'users.name as user_name')
            ->latest('majlis_histories.created_at')
            ->get();

        $this->historyModalOpen = true;
    }

    public function closeHistoryModal()
    {
        $this->historyModalOpen = false;
        $this->selectedMajlisHistory = [];
        $this->selectedMajlisTitle = '';
    }

    public function render()
    {
        $majalis = Majlis::query()
            ->with('user') // تحميل بيانات المشرف المنشئ
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.majlis-manager', [
            'majalis' => $majalis
        ])->layout('layouts.app');
    }
}