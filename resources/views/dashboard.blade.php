<x-app-layout>
    <x-slot name="header">
        <div dir="rtl">
            <h2 class="font-bold text-xl text-gray-900 dark:text-white leading-tight font-serif">
                لوحة العضو
            </h2>
        </div>
    </x-slot>

    <div class="py-12" dir="rtl">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm border border-gray-100 dark:border-gray-700 sm:rounded-xl">
                <div class="p-6 text-gray-900 dark:text-gray-100 space-y-4">
                    <p class="text-base font-medium">
                        مرحباً بك في مجالس القرآن، {{ Auth::user()->name }}.
                    </p>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        يمكنك تصفح المجالس العلمية، مشاركة تدبراتك وهداياتك، ومتابعة حالة مراجعتها من صفحة مساهماتي.
                    </p>
                    <div class="flex flex-wrap gap-3 pt-2">
                        <a href="{{ route('majalis.index') }}"
                           class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                            تصفح المجالس
                        </a>
                        <a href="{{ route('my-contributions') }}"
                           class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 text-sm font-semibold rounded-lg transition">
                            مساهماتي
                        </a>
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}"
                               class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
                                لوحة الإحصائيات
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>