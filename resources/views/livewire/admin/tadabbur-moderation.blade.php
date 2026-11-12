<div class="py-12" dir="rtl" x-data="{ isOpen: false, action: 'approve', tadabburId: null }">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <div class="mb-6 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">مراجعة التدبرات المعلقة</h2>
            <span class="px-3 py-1 bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300 rounded-full text-sm font-semibold">
                {{ $pendingTadabburat->total() }} قيد الانتظار
            </span>
        </div>

        @if (session()->has('message'))
            <div class="mb-4 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 rounded-lg text-sm">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="mb-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                
                @forelse ($pendingTadabburat as $tadabbur)
                    <div class="p-6 transition-colors duration-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <div class="flex flex-col">
                            
                            <div class="w-full">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="font-bold text-gray-900 dark:text-white">{{ $tadabbur->user->name }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400" dir="rtl">
                                        {{ \Carbon\Carbon::parse($tadabbur->created_at)->locale('ar')->diffForHumans() }}
                                    </span>
                                </div>
                                
                                <div class="mb-3 text-sm text-emerald-600 dark:text-emerald-400 font-semibold border-r-2 border-emerald-500 pr-2">
                                    المجلس: {{ $tadabbur->majlis->title }}
                                </div>
                                
                                <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border border-gray-100 dark:border-gray-700">
                                    {{ $tadabbur->content }}
                                </p>
                            </div>

                            <div class="mt-5 pt-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700/50">
                                <!-- استخدمنا x-on:click بدلاً من @click لتجنب تعارض Blade -->
                                <button type="button" 
                                        x-on:click="isOpen = true; action = 'approve'; tadabburId = {{ $tadabbur->id }}"
                                        class="inline-flex items-center justify-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-md transition">
                                    ✅ موافقة ونشر التدبر
                                </button>
                                
                                <button type="button" 
                                        x-on:click="isOpen = true; action = 'reject'; tadabburId = {{ $tadabbur->id }}"
                                        class="inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-md transition">
                                    🗑️ رفض وحذف
                                </button>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center text-gray-500 dark:text-gray-400">
                        <p class="text-lg">لا توجد أي تدبرات معلقة حالياً. كل شيء على ما يرام! 🎉</p>
                    </div>
                @endforelse
                
            </div>
        </div>

        <!-- قسم مراجعة الهدايات المعلقة -->
        <div class="mt-12">
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">مراجعة الهدايات المعلقة</h2>
                <span class="px-3 py-1 bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300 rounded-full text-sm font-semibold">
                    {{ $this->pendingHidayat->total() }} قيد الانتظار
                </span>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($this->pendingHidayat as $hidayah)
                        <div class="p-6 transition-colors duration-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <div class="flex flex-col">
                                
                                <div class="w-full">
                                    <div class="flex items-center gap-3 mb-2">
                                        <span class="font-bold text-gray-900 dark:text-white">{{ $hidayah->user->name }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400" dir="rtl">
                                            {{ \Carbon\Carbon::parse($hidayah->created_at)->locale('ar')->diffForHumans() }}
                                        </span>
                                    </div>
                                    
                                    <div class="mb-3 text-sm text-emerald-600 dark:text-emerald-400 font-semibold border-r-2 border-emerald-500 pr-2">
                                        المجلس: {{ $hidayah->majlis->title }}
                                    </div>
                                    
                                    <p class="text-gray-700 dark:text-gray-300 text-sm leading-relaxed bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border border-gray-100 dark:border-gray-700">
                                        {{ $hidayah->content }}
                                    </p>
                                </div>

                                <!-- أزرار الإجراء الخاصة بالهدايات -->
                                <div class="mt-5 pt-4 flex justify-end gap-3 border-t border-gray-100 dark:border-gray-700/50">
                                    <button type="button" 
                                            x-on:click="isOpen = true; action = 'approveHidayah'; tadabburId = {{ $hidayah->id }}"
                                            class="inline-flex items-center justify-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-md transition">
                                        ✅ موافقة ونشر الهداية
                                    </button>
                                    
                                    <button type="button" 
                                            x-on:click="isOpen = true; action = 'rejectHidayah'; tadabburId = {{ $hidayah->id }}"
                                            class="inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-md transition">
                                        🗑️ رفض وحذف
                                    </button>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center text-gray-500 dark:text-gray-400">
                            <p class="text-lg">لا توجد أي هدايات معلقة حالياً. ممتاز! 🎉</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="mt-6">
                {{ $this->pendingHidayat->links() }}
            </div>
        </div>

        <div class="mt-6">
            {{ $pendingTadabburat->links() }}
        </div>
        
    </div>

    <!-- النافذة المنبثقة (Modal) -->
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
                     class="relative transform overflow-hidden rounded-xl bg-white dark:bg-gray-800 text-right shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100 dark:border-gray-700">
                    
                    <div class="px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start sm:gap-4">
                            <!-- أيقونة ديناميكية -->
                            <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full sm:mx-0 sm:h-10 sm:w-10"
                                 :class="action === 'reject' ? 'bg-red-100 dark:bg-red-900/30' : 'bg-emerald-100 dark:bg-emerald-900/30'">
                                <svg x-show="action === 'reject'" class="h-6 w-6 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <svg x-show="action === 'approve'" class="h-6 w-6 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            
                            <div class="mt-3 text-center sm:ml-0 sm:mr-4 sm:mt-0 sm:text-right">
                                <h3 class="text-lg font-semibold leading-6 text-gray-900 dark:text-white" id="modal-title" 
                                    x-text="action.includes('reject') ? 'تأكيد الرفض والحذف' : 'تأكيد الموافقة والنشر'"></h3>

                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed" 
                                    x-text="action.includes('reject') ? 'هل أنت متأكد من رغبتك في رفض هذا العنصر وحذفه نهائياً؟ هذا الإجراء لا يمكن التراجع عنه.' : 'هل أنت متأكد من رغبتك في الموافقة على هذا العنصر؟ سيتم نشره فوراً ليراه جميع زوار المنصة.'"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700/50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-3">
                        <!-- أمر x-on:click للتواصل مع Livewire -->
                        <button type="button" 
                                x-on:click="$wire[action](tadabburId); isOpen = false"
                                class="inline-flex w-full justify-center rounded-md px-4 py-2 text-sm font-semibold text-white shadow-sm sm:w-auto transition"
                                :class="action.includes('reject') ? 'bg-red-600 hover:bg-red-700' : 'bg-emerald-600 hover:bg-emerald-700'"
                                x-text="action.includes('reject') ? 'نعم، احذف العنصر' : 'نعم، انشر العنصر'">
                        </button>
                        
                        <button type="button" 
                                x-on:click="isOpen = false"
                                class="mt-3 inline-flex w-full justify-center rounded-md bg-white dark:bg-gray-800 px-4 py-2 text-sm font-semibold text-gray-900 dark:text-gray-300 shadow-sm ring-1 ring-inset ring-gray-300 dark:ring-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 sm:mt-0 sm:w-auto transition">
                            إلغاء
                        </button>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>