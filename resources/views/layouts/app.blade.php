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

        <!-- سكربت فوري للتحقق من الثيم وتطبيقه قبل تحميل الصفحة لمنع الوميض الأبيض -->
        <script>
            if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 transition-colors duration-200"
          x-data="{
              theme: localStorage.getItem('theme') || (document.documentElement.classList.contains('dark') ? 'dark' : 'light')
          }"
          x-init="
              $watch('theme', val => {
                  localStorage.setItem('theme', val);
                  document.documentElement.classList.toggle('dark', val === 'dark');
              });
          ">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow border-b border-gray-100 dark:border-gray-700">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- نافذة التذكير المنبثقة للزوار غير المسجلين (تظهر عند الدخول وكل 10 دقائق) -->
        @guest
            <div x-data="{
                    showAuthModal: false,
                    init() {
                        let lastShown = localStorage.getItem('last_auth_modal_time');
                        let now = new Date().getTime();
                        
                        // تظهر فور الدخول للموقع إذا لم تظهر خلال الـ 10 دقائق الأخيرة
                        if (!lastShown || (now - lastShown > 600000)) {
                            this.triggerModal();
                        }

                        // تكرار الظهور كل 10 دقائق (600,000 ملي ثانية) طالما الزوار يتصفحون الموقع
                        setInterval(() => {
                            this.triggerModal();
                        }, 600000);
                    },
                    triggerModal() {
                        this.showAuthModal = true;
                        localStorage.setItem('last_auth_modal_time', new Date().getTime());
                    }
                 }"
                 x-show="showAuthModal"
                 x-cloak
                 class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/70 backdrop-blur-sm p-4" 
                 dir="rtl">
                
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100 dark:border-gray-700 p-6 space-y-6 transform transition-all">
                    
                    <!-- أيقونة وعنوان -->
                    <div class="text-center space-y-2">
                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400">
                            <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white font-serif">انضم إلى مجالس القرآن</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            سجل الدخول لتتمكن من مشاركة تدبراتك الإيمانية، إرسال الهدايات السلوكية، والتفاعل مع مجتمع القراء.
                        </p>
                    </div>

                    <!-- أزرار الإجراءات -->
                    <div class="space-y-3">
                        <a href="{{ route('login') }}" 
                           class="w-full flex items-center justify-center px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-semibold transition shadow-sm">
                            تسجيل الدخول
                        </a>
                        
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" 
                               class="w-full flex items-center justify-center px-4 py-2.5 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-sm font-semibold transition">
                                إنشاء حساب جديد
                            </a>
                        @endif
                    </div>

                    <!-- زر الإغلاق -->
                    <div class="text-center pt-2">
                        <button @click="showAuthModal = false" class="text-xs text-gray-400 hover:text-gray-600 dark:hover:text-gray-200 underline transition">
                            لاحقاً، متابعة التصفح
                        </button>
                    </div>

                </div>
            </div>
        @endguest

        @livewireScripts
    </body>
</html>