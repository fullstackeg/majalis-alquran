<div class="py-12" dir="rtl">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        
        <!-- رأس الصفحة -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 flex flex-col sm:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white font-serif">لوحة تحكم المشرف الإحصائية</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">نظرة عامة على نشاط المنصة والمحتوى القرآني</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.majalis.index') }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition shadow-sm">
                    + إدارة المجالس
                </a>
                <a href="{{ route('admin.tadabburat.pending') }}" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-sm font-semibold transition shadow-sm">
                    مراجعة المعلقات 
                    @if(($pendingTadabburat + $pendingHidayat) > 0)
                        <span class="bg-white text-amber-800 text-xs px-2 py-0.5 rounded-full mr-1 font-bold">{{ $pendingTadabburat + $pendingHidayat }}</span>
                    @endif
                </a>
            </div>
        </div>

        <!-- بطاقات الإحصائيات (Grid Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- إجمالي المجالس -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 space-y-2">
                <div class="flex justify-between items-center text-gray-500 dark:text-gray-400 text-sm">
                    <span>إجمالي المجالس</span>
                    <span class="p-2 bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 rounded-xl">📖</span>
                </div>
                <div class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $totalMajalis }}</div>
                <div class="text-xs text-gray-400">تضم {{ $totalAyat }} مقطعاً قرآنياً</div>
            </div>

            <!-- التدبرات (منشورة ومعلقة) -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 space-y-2">
                <div class="flex justify-between items-center text-gray-500 dark:text-gray-400 text-sm">
                    <span>تدبرات القراء</span>
                    <span class="p-2 bg-blue-50 dark:bg-blue-950/50 text-blue-600 dark:text-blue-400 rounded-xl">💡</span>
                </div>
                <div class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $approvedTadabburat }}</div>
                <div class="text-xs text-amber-600 dark:text-amber-400 font-medium">قيد المراجعة: {{ $pendingTadabburat }}</div>
            </div>

            <!-- الهدايات (منشورة ومعلقة) -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 space-y-2">
                <div class="flex justify-between items-center text-gray-500 dark:text-gray-400 text-sm">
                    <span>الهدايات السلوكية</span>
                    <span class="p-2 bg-purple-50 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400 rounded-xl">🌱</span>
                </div>
                <div class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $approvedHidayat }}</div>
                <div class="text-xs text-amber-600 dark:text-amber-400 font-medium">قيد المراجعة: {{ $pendingHidayat }}</div>
            </div>

            <!-- المستخدمين -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 space-y-2">
                <div class="flex justify-between items-center text-gray-500 dark:text-gray-400 text-sm">
                    <span>أعضاء المنصة</span>
                    <span class="p-2 bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 rounded-xl">👥</span>
                </div>
                <div class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $totalUsers }}</div>
                <div class="text-xs text-gray-400">مستخدم مسجل في المنصة</div>
            </div>

        </div>

        <!-- أحدث المجالس المضافة -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">أحدث المجالس المضافة</h3>
                <a href="{{ route('admin.majalis.index') }}" class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold hover:underline">عرض الكل ←</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-right text-sm text-gray-500 dark:text-gray-400">
                    <thead class="bg-gray-50 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-3">عنوان المجلس</th>
                            <th class="px-6 py-3">المشرف</th>
                            <th class="px-6 py-3">الرمز (Slug)</th>
                            <th class="px-6 py-3">تاريخ الإنشاء</th>
                            <th class="px-6 py-3 text-center">إجراء</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse($recentMajalis as $majlis)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                                <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $majlis->title }}</td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $majlis->user->name ?? 'غير محدد' }}</td>
                                <td class="px-6 py-4 font-mono text-xs text-emerald-600 dark:text-emerald-400">#{{ $majlis->slug }}</td>
                                <td class="px-6 py-4 text-xs">{{ $majlis->created_at?->format('Y-m-d H:i') }}</td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('majalis.show', $majlis) }}" target="_blank" class="text-emerald-600 dark:text-emerald-400 hover:underline text-xs font-semibold">
                                        معاينة
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">لا توجد مجالس مضافة بعد.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>