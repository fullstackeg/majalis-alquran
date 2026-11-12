<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Majlis;
use App\Models\Ayah;

class AyahManager extends Component
{
    use WithPagination;

    public Majlis $majlis;

    public $ayahId = null;
    public $surah_name = '';
    public $from_ayah = '';
    public $to_ayah = '';
    public $quranic_text = '';
    public $bayan_text = '';

    public $isOpen = false;
    public $isEditMode = false;

    protected function rules()
    {
        return [
            'surah_name' => 'required|string|max:255',
            'from_ayah' => 'required|integer',
            'to_ayah' => 'required|integer',
            'quranic_text' => 'required|string',
            'bayan_text' => 'nullable|string',
        ];
    }

    public function mount(Majlis $majlis)
    {
        $this->majlis = $majlis;
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

        $this->majlis->ayat()->create([
            'surah_name' => $this->surah_name,
            'from_ayah' => $this->from_ayah,
            'to_ayah' => $this->to_ayah,
            'quranic_text' => $this->quranic_text,
            'bayan_text' => $this->bayan_text,
        ]);

        session()->flash('message', 'تم إضافة المقطع القرآني بنجاح.');
        $this->closeModal();
    }

    public function edit($id)
    {
        $ayah = Ayah::where('majlis_id', $this->majlis->id)->findOrFail($id);
        $this->ayahId = $ayah->id;
        $this->surah_name = $ayah->surah_name;
        $this->from_ayah = $ayah->from_ayah;
        $this->to_ayah = $ayah->to_ayah;
        $this->quranic_text = $ayah->quranic_text;
        $this->bayan_text = $ayah->bayan_text;

        $this->isOpen = true;
        $this->isEditMode = true;
    }

    public function update()
    {
        $this->validate();

        $ayah = Ayah::where('majlis_id', $this->majlis->id)->findOrFail($this->ayahId);

        $ayah->update([
            'surah_name' => $this->surah_name,
            'from_ayah' => $this->from_ayah,
            'to_ayah' => $this->to_ayah,
            'quranic_text' => $this->quranic_text,
            'bayan_text' => $this->bayan_text,
        ]);

        session()->flash('message', 'تم تحديث المقطع بنجاح.');
        $this->closeModal();
    }

    public function delete($id)
    {
        Ayah::where('majlis_id', $this->majlis->id)->findOrFail($id)->delete();
        session()->flash('message', 'تم حذف المقطع بنجاح.');
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->ayahId = null;
        $this->surah_name = '';
        $this->from_ayah = '';
        $this->to_ayah = '';
        $this->quranic_text = '';
        $this->bayan_text = '';
    }

    public function render()
    {
        return view('livewire.admin.ayah-manager', [
            'ayat' => $this->majlis->ayat()->latest()->paginate(10)
        ])->layout('layouts.app');
    }
}
