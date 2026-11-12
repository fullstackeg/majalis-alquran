<div class="py-12" dir="rtl">
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

                            <button wire:click="deleteTadabbur({{ $tadabbur->id }})" 
                                    wire:confirm="هل أنت متأكد من حذف هذا التدبر؟"
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

                            <button wire:click="deleteHidayah({{ $hidayah->id }})" 
                                    wire:confirm="هل أنت متأكد من حذف هذه الهداية؟"
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
</div>