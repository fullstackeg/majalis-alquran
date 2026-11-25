<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Majlis;
use App\Models\Tadabbur;
use App\Models\Hidayah;
use App\Models\User;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'totalMajalis' => Majlis::count(),
            'totalAyat' => \App\Models\Ayah::count(),
            'pendingTadabburat' => Tadabbur::where('status', 'pending')->count(),
            'approvedTadabburat' => Tadabbur::where('status', 'approved')->count(),
            'pendingHidayat' => Hidayah::where('status', 'pending')->count(),
            'approvedHidayat' => Hidayah::where('status', 'approved')->count(),
            'totalUsers' => User::count(),
            'recentMajalis' => Majlis::with('user')->latest()->take(5)->get(),
        ])->layout('layouts.app');
    }
}
