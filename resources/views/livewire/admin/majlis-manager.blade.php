<div class="py-12" dir="rtl" x-data="{ confirmOpen: false, confirmAction: null, confirmMessage: '' }">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- رأس الصفحة وأزرار التحكم -->
        <div class="flex flex-col sm:flex-row justify-between items-center bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white font-serif">إدارة المجالس العلمية</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">إضافة، تعديل، وحذف مجالس القرآن الكريم وتدبراتها</p>
            </div>

            <button wire:click="create" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-lg shadow-sm transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                إضافة مجلس جديد
            </button>
        </div>

        @if (session()->has('message'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 rounded-lg text-sm">
                {{ session('message') }}
            </div>
        @endif

        @if (session()->has('error'))
            <div class="p-4 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 text-amber-700 dark:text-amber-300 rounded-lg text-sm">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        <!-- شريط البحث الفوري وجدول العرض -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700">
            <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                <input wire:model.live.debounce.300ms="search" type="search" 
                    class="w-full sm:w-1/3 p-2.5 text-sm border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-900 dark:border-gray-700 dark:text-white focus:ring-emerald-500 focus:border-emerald-500" 
                    placeholder="بحث في المجالس...">
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-right text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">عنوان المجلس</th>
                            <th class="px-6 py-3">المشرف / المنشئ</th>
                            <th class="px-6 py-3">الرمز (Slug)</th>
                            <th class="px-6 py-3">تواريخ النظام</th>
                            <th class="px-6 py-3 text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($majalis as $majlis)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $majlis->title }}</td>
                                
                                <!-- اسم المشرف/المنشئ -->
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                        {{ $majlis->user->name ?? 'غير محدد' }}
                                    </div>
                                </td>

                                <td class="px-6 py-4 font-mono text-xs text-emerald-600 dark:text-emerald-400">#{{ $majlis->slug }}</td>

                                <!-- إظهار التواريخ بدقة -->
                                <td class="px-6 py-4 text-xs space-y-1">
                                    <div class="text-gray-600 dark:text-gray-300">إنشاء: {{ $majlis->created_at?->format('Y-m-d H:i') }}</div>
                                    <div class="text-gray-400">تعديل: {{ $majlis->updated_at?->diffForHumans() }}</div>
                                </td>

                                <!-- الأزرار مع الأيقونات الفاخرة -->
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        
                                        <!-- زر عرض سجل التعديلات -->
                                        <button wire:click="showHistory({{ $majlis->id }})" 
                                            title="سجل التعديلات"
                                            class="p-2 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/40 dark:hover:bg-emerald-900/60 text-emerald-600 dark:text-emerald-400 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                        </button>
                                        
                                        <!-- زر التعديل -->
                                        <button wire:click="edit({{ $majlis->id }})" 
                                                title="تعديل المجلس"
                                                class="p-2 bg-blue-50 hover:bg-blue-100 dark:bg-blue-950/40 dark:hover:bg-blue-900/60 text-blue-600 dark:text-blue-400 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                            </svg>
                                        </button>
                                        
                                        <!-- زر الحذف -->
                                        <button @click="confirmOpen = true; confirmMessage = 'هل أنت متأكد تماماً من رغبتك في حذف هذا المجلس نهائياً؟'; confirmAction = () => { $wire.delete({{ $majlis->id }}); confirmOpen = false; }" 
                                                title="حذف المجلس"
                                                class="p-2 bg-red-50 hover:bg-red-100 dark:bg-red-950/40 dark:hover:bg-red-900/60 text-red-600 dark:text-red-400 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>

                                        <!-- زر الانتقال لإدارة الآيات والمقاطع -->
                                        <a href="{{ route('admin.majalis.ayat', $majlis) }}" 
                                        title="إدارة آيات المجلس"
                                        class="p-2 bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/40 dark:hover:bg-amber-900/60 text-amber-600 dark:text-amber-400 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                            </svg>
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">لا توجد مجالس مضافة حالياً.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4">
                {{ $majalis->links() }}
            </div>
        </div>

        <!-- نافذة النموذج (Modal) للإضافة والتعديل -->
        @if($isOpen)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70 backdrop-blur-sm p-4" dir="rtl">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-lg overflow-hidden border border-gray-100 dark:border-gray-700 p-6 space-y-4">
                    
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">
                        {{ $isEditMode ? 'تعديل المجلس' : 'إضافة مجلس جديد' }}
                    </h3>

                    <form wire:submit.prevent="storeOrUpdatePrompt" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">عنوان المجلس</label>
                            <input wire:model="title" type="text" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white text-sm focus:ring-emerald-500 focus:border-emerald-500">
                            @error('title') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">وصف المجلس</label>
                            <textarea wire:model="description" rows="4" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white text-sm focus:ring-emerald-500 focus:border-emerald-500"></textarea>
                            @error('description') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md text-sm font-semibold transition">إلغاء</button>
                            
                            <!-- زر الحفظ الذي يستدعي نافذة التأكيد الرائعة -->
                            <button type="button" 
                                    @click="confirmOpen = true; confirmMessage = 'هل أنت متأكد من حفظ وتأكيد هذه التغييرات؟'; confirmAction = () => { $wire.{{ $isEditMode ? 'update' : 'store' }}(); confirmOpen = false; }"
                                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-md text-sm font-semibold transition">
                                حفظ التغييرات
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        @endif

        <!-- نافذة التأكيد المنبثقة الاحترافية (Stunning Confirmation Modal) -->
        <div x-show="confirmOpen" style="display: none;" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity"></div>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-right shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-gray-100 dark:border-gray-700 p-6 space-y-4">
                        
                        <div class="flex items-center gap-4">
                            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900 dark:text-white">تأكيد الإجراء</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" x-text="confirmMessage"></p>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <button type="button" @click="confirmOpen = false" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-semibold transition hover:bg-gray-200">
                                تراجع
                            </button>
                            <button type="button" @click="confirmAction()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold transition shadow-sm">
                                نعم، متأكد
                            </button>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- نافذة عرض سجل التعديلات (History Modal) -->
    @if($historyModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70 backdrop-blur-sm p-4" dir="rtl">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden border border-gray-100 dark:border-gray-700 flex flex-col max-h-[85vh]">
                
                <!-- رأس النافذة -->
                <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-gray-900/50">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">سجل التعديلات والتاريخ</h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">المجلس: <span class="text-emerald-600 dark:text-emerald-400 font-semibold">{{ $selectedMajlisTitle }}</span></p>
                    </div>
                    <button wire:click="closeHistoryModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-200">
                        ✕
                    </button>
                </div>

                <!-- محتوى السجل (Timeline) -->
                <div class="p-6 overflow-y-auto space-y-4 flex-1">
                    @forelse($selectedMajlisHistory as $history)
                        <div class="p-4 bg-gray-50 dark:bg-gray-900/40 rounded-xl border border-gray-100 dark:border-gray-700/60 space-y-2">
                            <div class="flex justify-between items-center text-xs">
                                <span class="font-bold text-gray-800 dark:text-gray-200 flex items-center gap-1.5">
                                    👤 {{ $history->user_name }}
                                </span>
                                <span class="text-gray-400">
                                    {{ \Carbon\Carbon::parse($history->created_at)->locale('ar')->diffForHumans() }} 
                                    ({{ $history->created_at }})
                                </span>
                            </div>

                            <div class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">
                                الإجراء: {{ $history->action === 'created' ? 'إنشاء المجلس' : 'تحديث وتعديل' }}
                            </div>

                            @if($history->old_content)
                                <div class="text-xs text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/10 p-2.5 rounded-lg border border-red-100 dark:border-red-900/30">
                                    <span class="font-bold block mb-1">المحتوى قبل التعديل:</span>
                                    {{ $history->old_content }}
                                </div>
                            @endif

                            @if($history->new_content)
                                <div class="text-xs text-emerald-700 dark:text-emerald-300 bg-emerald-50 dark:bg-emerald-900/10 p-2.5 rounded-lg border border-emerald-100 dark:border-emerald-900/30">
                                    <span class="font-bold block mb-1">المحتوى بعد التعديل:</span>
                                    {{ $history->new_content }}
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-12 text-gray-500">
                            <p>لا يوجد أي سجل تعديلات مسجل لهذا المجلس حتى الآن.</p>
                        </div>
                    @endforelse
                </div>

                <!-- تذييل النافذة -->
                <div class="p-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 flex justify-end">
                    <button wire:click="closeHistoryModal" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-semibold transition">
                        إغلاق
                    </button>
                </div>

            </div>
        </div>
    @endif
</div>