<div class="py-12" dir="rtl" x-data="{ confirmOpen: false, confirmAction: null, confirmMessage: '' }">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- رأس الصفحة ومعلومات المجلس -->
        <div class="flex flex-col sm:flex-row justify-between items-center bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 gap-4">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('admin.majalis.index') }}" class="text-xs text-emerald-600 dark:text-emerald-400 hover:underline">← العودة للمجالس</a>
                </div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white font-serif">إدارة آيات ومقاطع المجلس</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">المجلس الحالي: <span class="text-emerald-600 dark:text-emerald-400 font-semibold">{{ $majlis->title }}</span></p>
            </div>

            <button wire:click="create" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-lg shadow-sm transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                إضافة آية / مقطع جديد
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

        <!-- جدول عرض الآيات -->
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-xl border border-gray-100 dark:border-gray-700">
            <div class="overflow-x-auto">
                <table class="w-full text-right text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">السورة ورقم الآية</th>
                            <th class="px-6 py-3">نص الآية الكريمة</th>
                            <th class="px-6 py-3 text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($ayat as $ayah)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                <!-- في جدول العرض -->
                                <td class="px-6 py-4 font-bold text-gray-900 dark:text-white whitespace-nowrap">
                                    {{ $ayah->surah_name }} 
                                    <span class="text-xs text-emerald-600 dark:text-emerald-400 font-mono">(من آية {{ $ayah->from_ayah }} إلى {{ $ayah->to_ayah }})</span>
                                </td>
                                <td class="px-6 py-4 text-gray-800 dark:text-gray-200 font-serif leading-relaxed text-base">
                                    "{{ $ayah->quranic_text }}"
                                    @if($ayah->bayan_text)
                                        <div class="text-xs text-gray-500 mt-1">البيان: {{ Str::limit($ayah->bayan_text, 80) }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <button wire:click="edit({{ $ayah->id }})" title="تعديل الآية" class="p-2 bg-blue-50 hover:bg-blue-100 dark:bg-blue-950/40 dark:hover:bg-blue-900/60 text-blue-600 dark:text-blue-400 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg>
                                        </button>
                                        <button @click="confirmOpen = true; confirmMessage = 'هل أنت متأكد من حذف هذه الآية نهائياً؟'; confirmAction = () => { $wire.delete({{ $ayah->id }}); confirmOpen = false; }" title="حذف الآية" class="p-2 bg-red-50 hover:bg-red-100 dark:bg-red-950/40 dark:hover:bg-red-900/60 text-red-600 dark:text-red-400 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-gray-500">لا توجد آيات أو مقاطع مضافة لهذا المجلس بعد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4">
                {{ $ayat->links() }}
            </div>
        </div>

        <!-- نافذة الإضافة والتعديل (Modal) -->
        @if($isOpen)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70 backdrop-blur-sm p-4" dir="rtl">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl w-full max-w-lg overflow-hidden border border-gray-100 dark:border-gray-700 p-6 space-y-4">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $isEditMode ? 'تعديل الآية' : 'إضافة آية جديدة' }}</h3>
                    <form wire:submit.prevent="storeOrUpdate" class="space-y-4">
                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">اسم السورة</label>
                                <input wire:model="surah_name" type="text" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">من آية</label>
                                <input wire:model="from_ayah" type="number" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">إلى آية</label>
                                <input wire:model="to_ayah" type="number" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">النص القرآني</label>
                            <textarea wire:model="quranic_text" rows="3" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white text-sm"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">نص البيان (التفسير/الشرح)</label>
                            <textarea wire:model="bayan_text" rows="3" class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white text-sm"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">نص الآية الكريمة</label>
                            <textarea wire:model="content" rows="3" placeholder="اكتب نص الآية بالرسم العثماني..." class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-white text-sm focus:ring-emerald-500"></textarea>
                            @error('content') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <button type="button" wire:click="closeModal" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md text-sm font-semibold transition">إلغاء</button>
                            <button type="button" @click="confirmOpen = true; confirmMessage = 'هل أنت متأكد من حفظ وتأكيد هذه التغييرات؟'; confirmAction = () => { $wire.{{ $isEditMode ? 'update' : 'store' }}(); confirmOpen = false; }" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-md text-sm font-semibold transition">حفظ التغييرات</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <!-- نافذة التأكيد المنبثقة (Confirmation Modal) -->
        <div x-show="confirmOpen" style="display: none;" class="relative z-50">
            <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <div class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-right shadow-2xl p-6 space-y-4 max-w-md w-full border border-gray-100 dark:border-gray-700">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">تأكيد الإجراء</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400" x-text="confirmMessage"></p>
                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <button @click="confirmOpen = false" class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-semibold">تراجع</button>
                            <button @click="confirmAction()" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-semibold">نعم، متأكد</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>