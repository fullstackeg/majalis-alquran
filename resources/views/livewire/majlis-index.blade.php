<div class="py-12" dir="rtl">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- عنوان القسم وحقل البحث -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="text-center sm:text-right">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">مجالس القرآن الكريم</h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">تدبرات ومجالس علمية على منهج الإمام الشيخ فريد الأنصاري رحمه الله</p>
            </div>

            <!-- حقل البحث الحي -->
            <div class="w-full sm:w-1/3 relative">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="search" 
                    class="block w-full p-3 pr-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-white focus:ring-emerald-500 focus:border-emerald-500 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500 shadow-sm transition" 
                    placeholder="ابحث عن مجلس، اسم سورة...">
            </div>
        </div>

        <!-- شبكة عرض المجالس -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($majalis as $majlis)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700 flex flex-col justify-between transition hover:shadow-md">
                    <div class="p-6">
                        <!-- عرض الـ slug بخط صغير أو كرمز تعريفي نظيف إن أردت إظهاره (اختياري) -->
                        <div class="mb-2 text-xs text-emerald-600 dark:text-emerald-400 font-mono">
                            #{{ $majlis->slug }}
                        </div>

                        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100 mb-2">
                            {{ $majlis->title }}
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-3 mb-4">
                            {{ $majlis->description }}
                        </p>
                    </div>

                    <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/50 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                        <div class="flex gap-4">
                            <span>📖 {{ $majlis->ayat_count }} مقطع</span>
                            <span>💡 {{ $majlis->tadabburat_count }} تدبر</span>
                            <span>🌱 {{ $majlis->hidayat_count }} هدايات</span>
                        </div>
                        
                        <!-- الزر سيقوم بتوجيه المستخدم تلقائياً باستخدام الـ slug الآمن -->
                        <a href="{{ route('majalis.show', $majlis) }}" class="inline-flex items-center px-3 py-1.5 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 transition">
                            دخـول المجلس
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">
                    @if($search)
                        <p class="text-gray-500 dark:text-gray-400 text-lg">لم نجد أي مجالس تطابق بحثك عن: "<span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $search }}</span>"</p>
                    @else
                        <p class="text-gray-500 dark:text-gray-400 text-lg">لا توجد مجالس منشورة حالياً.</p>
                    @endif
                </div>
            @endforelse
        </div>

        <!-- أزرار تصفح الصفحات (Pagination) -->
        <div class="mt-8">
            {{ $majalis->links() }}
        </div>

    </div>
</div>