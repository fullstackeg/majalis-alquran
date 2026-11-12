<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Tadabbur;
use Livewire\WithPagination;

class TadabburModeration extends Component
{
    use WithPagination;

    // الموافقة على التدبر
    public function approve($id)
    {
        $tadabbur = Tadabbur::findOrFail($id);
        $tadabbur->update(['status' => 'approved']);

        session()->flash('message', 'تم الموافقة على التدبر بنجاح ونشره للعامة.');
    }

    // رفض وحذف التدبر
    public function reject($id)
    {
        $tadabbur = Tadabbur::findOrFail($id);
        $tadabbur->delete();

        session()->flash('error', 'تم حذف التدبر المرفوض.');
    }

    public function getPendingHidayatProperty()
    {
        return \App\Models\Hidayah::where('status', 'pending')
            ->with(['user', 'majlis'])
            ->latest()
            ->paginate(10, ['*'], 'hidayatPage');
    }

    public function approveHidayah($id)
    {
        \App\Models\Hidayah::findOrFail($id)->update(['status' => 'approved']);
        session()->flash('message', 'تمت الموافقة على الهداية ونشرها بنجاح.');
    }

    public function rejectHidayah($id)
    {
        \App\Models\Hidayah::findOrFail($id)->delete();
        session()->flash('error', 'تم رفض وحذف الهداية.');
    }

    public function render()
    {
        // جلب التدبرات المعلقة فقط مع بيانات المستخدم والمجلس
        $pendingTadabburat = Tadabbur::where('status', 'pending')
            ->with(['user', 'majlis'])
            ->latest()
            ->paginate(10);

        return view('livewire.admin.tadabbur-moderation', [
            'pendingTadabburat' => $pendingTadabburat
        ]); 
    }
}