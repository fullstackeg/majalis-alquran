<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tadabbur;
use App\Models\Hidayah;

class MyContributions extends Component
{
    use WithPagination;

    public $tab = 'tadabburat'; // التبويب الافتراضي: tadabburat أو hidayat

    public function switchTab($tabName)
    {
        $this->tab = $tabName;
        $this->resetPage();
    }

    public function deleteTadabbur($id)
    {
        $tadabbur = Tadabbur::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $tadabbur->delete();
        session()->flash('message', 'تم حذف التدبر بنجاح.');
    }

    public function deleteHidayah($id)
    {
        $hidayah = Hidayah::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        $hidayah->delete();
        session()->flash('message', 'تم حذف الهداية بنجاح.');
    }

    public function render()
    {
        $tadabburat = Tadabbur::where('user_id', auth()->id())
            ->with('majlis')
            ->latest()
            ->paginate(5, ['*'], 'tadabburPage');

        $hidayat = Hidayah::where('user_id', auth()->id())
            ->with('majlis')
            ->latest()
            ->paginate(5, ['*'], 'hidayatPage');

        return view('livewire.my-contributions', [
            'tadabburat' => $tadabburat,
            'hidayat' => $hidayat,
        ])->layout('layouts.app');
    }
}
