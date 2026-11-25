<div class="py-12" dir="rtl" x-data="{ isOpen: false, deleteType: '', itemId: null, itemTitle: '' }">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- رأس الصفحة -->
        <div class="flex justify-between items-center bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white font-serif">مساهماتي الإيمانية</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">تتبع حالة تدبراتك وهداياتك المرسلة ومراجعتها</p>
            </div>
            
            <!-- أزرار التبديل بين التدبرات والهدايات -->
            <div class="flex gap-2 bg-gray-100 dark:bg-gray-900 p-1.5 rounded-lg">
                <button wire:click="switchTab('tadabburat')" 
                        class="px-4 py-2 text-sm font-semibold rounded-md transition {{ $tab === 'tadabburat' ? 'bg-white dark:bg-gray-800 text-emerald-600 dark:text-emerald-400 shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900' }}">
                    تدبراتي ({{ auth()->user()->tadabburat()->count() }})
                </button>
                <button wire:click="switchTab('hidayat')" 
                        class="px-4 py-2 text-sm font-semibold rounded-md transition {{ $tab === 'hidayat' ? 'bg-white dark:bg-gray-800 text-emerald-600 dark:text-emerald-400 shadow-sm' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900' }}">
                    هداياتي ({{ auth()->user()->hidayat()->count() }})
                </button>
            </div>
        </div>

        @if (session()->has('message'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 rounded-lg text-sm">
                {{ session('message') }}
            </div>
        @endif

        <!-- المحتوى حسب التبويب النشط -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700">
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                
                @if($tab === 'tadabburat')
                    <!-- عرض التدبرات -->
                    @forelse($tadabburat as $tadabbur)
                        <div class="p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <div class="space-y-2 flex-1">
                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/40 px-2.5 py-1 rounded-md">
                                        المجلس: {{ $tadabbur->majlis->title }}
                                    </span>
                                    
                                    <!-- شارة الحالة -->
                                    @if($tadabbur->status === 'approved')
                                        <span class="text-xs bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300 px-2.5 py-0.5 rounded-full font-medium">تم النشر</span>
                                    @else
                                        <span class="text-xs bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300 px-2.5 py-0.5 rounded-full font-medium">قيد المراجعة</span>
                                    @endif
                                </div>
                                <p class="text-gray-800 dark:text-gray-200 text-sm leading-relaxed">{{ $tadabbur->content }}</p>
                                <span class="text-xs text-gray-400">{{ $tadabbur->created_at->locale('ar')->diffForHumans() }}</span>
                            </div>

                            <button type="button" 
                                    x-on:click="isOpen = true; deleteType = 'tadabbur'; itemId = {{ $tadabbur->id }};" 
                                    class="text-red-500 hover:text-red-700 text-sm font-medium px-3 py-1.5 rounded-lg border border-red-200 dark:border-red-800 hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                حذف
                            </button>
                        </div>
                    @empty
                        <div class="p-12 text-center text-gray-500 dark:text-gray-400">
                            <p>لم تقم بإضافة أي تدبرات بعد.</p>
                        </div>
                    @endforelse
                    
                    <div class="p-4">
                        {{ $tadabburat->links() }}
                    </div>

                @else
                    <!-- عرض الهدايات -->
                    @forelse($hidayat as $hidayah)
                        <div class="p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                            <div class="space-y-2 flex-1">
                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/40 px-2.5 py-1 rounded-md">
                                        المجلس: {{ $hidayah->majlis->title }}
                                    </span>
                                    
                                    <!-- شارة الحالة -->
                                    @if($hidayah->status === 'approved')
                                        <span class="text-xs bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300 px-2.5 py-0.5 rounded-full font-medium">تم النشر</span>
                                    @else
                                        <span class="text-xs bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300 px-2.5 py-0.5 rounded-full font-medium">قيد المراجعة</span>
                                    @endif
                                </div>
                                <p class="text-gray-800 dark:text-gray-200 text-sm leading-relaxed">{{ $hidayah->content }}</p>
                                <span class="text-xs text-gray-400">{{ $hidayah->created_at->locale('ar')->diffForHumans() }}</span>
                            </div>

                            <button type="button" 
                                    x-on:click="isOpen = true; deleteType = 'hidayah'; itemId = {{ $hidayah->id }};" 
                                    class="text-red-500 hover:text-red-700 text-sm font-medium px-3 py-1.5 rounded-lg border border-red-200 dark:border-red-800 hover:bg-red-50 dark:hover:bg-red-900/20 transition">
                                حذف
                            </button>
                        </div>
                    @empty
                        <div class="p-12 text-center text-gray-500 dark:text-gray-400">
                            <p>لم تقم بإضافة أي هدايات بعد.</p>
                        </div>
                    @endforelse

                    <div class="p-4">
                        {{ $hidayat->links() }}
                    </div>
                @endif

            </div>
        </div>

    </div>

    <!-- نافذة التأكيد المنبثقة (Real Custom Modal) -->
    <div x-show="isOpen" style="display: none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <!-- خلفية ضبابية -->
        <div x-show="isOpen" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                
                <!-- مربع النافذة -->
                <div x-show="isOpen" 
                     x-on:click.outside="isOpen = false"
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-right shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100 dark:border-gray-700 p-6 space-y-6">
                    
                    <div class="flex items-center gap-4">
                        <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white">تأكيد الحذف</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">هل أنت متأكد من رغبتك في حذف هذه المساهمة؟ لا يمكن التراجع عن هذا الإجراء.</p>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" 
                                x-on:click="isOpen = false"
                                class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-xl text-sm font-semibold transition">
                            إلغاء
                        </button>
                        
                        <button type="button" 
                                x-on:click="if(deleteType === 'tadabbur') { $wire.deleteTadabbur(itemId); } else { $wire.deleteHidayah(itemId); } isOpen = false;"
                                class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-semibold transition shadow-sm">
                            نعم، احذف نهائياً
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>