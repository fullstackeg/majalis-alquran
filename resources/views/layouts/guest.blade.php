<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'مجالس القرآن') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- سكربت فوري للتحقق من الثيم وتطبيقه قبل تحميل الصفحة لمنع الوميض الأبيض -->
        <script>
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-200">
        
        <div class="min-h-screen flex flex-col justify-center items-center p-6">

            <!-- حاوية العناصر في المنتصف -->
            <div class="w-full sm:max-w-md flex flex-col items-center">
                
                <!-- شعار المنصة في أعلى البطاقة -->
                <div class="mb-6">
                    <a href="{{ route('majalis.index') }}" class="flex items-center gap-2 group">
                        <div class="p-3 bg-emerald-100 dark:bg-emerald-900/40 rounded-2xl text-emerald-600 dark:text-emerald-400 shadow-sm transition group-hover:scale-105">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </a>
                </div>

                <!-- بطاقة المحتوى (النموذج) -->
                <div class="w-full bg-white dark:bg-gray-800 shadow-xl shadow-gray-100 dark:shadow-none overflow-hidden sm:rounded-2xl border border-gray-100 dark:border-gray-700 p-8">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>