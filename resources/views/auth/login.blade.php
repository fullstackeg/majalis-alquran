<x-guest-layout>
    <div dir="rtl" class="text-right">
        
        <!-- عنوان الصفحة -->
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white font-serif">تسجيل الدخول إلى مجالس القرآن</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">مرحباً بك مجدداً، أضف بصمتك الإيمانية وتدبراتك</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" value="البريد الإلكتروني" class="text-gray-700 dark:text-gray-300" />
                <x-text-input id="email" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" value="كلمة المرور" class="text-gray-700 dark:text-gray-300" />
                <x-text-input id="password" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 dark:border-gray-700 text-emerald-600 shadow-sm focus:ring-emerald-500 dark:bg-gray-900 dark:focus:ring-offset-gray-800" name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">تذكرني</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm text-emerald-600 dark:text-emerald-400 hover:underline" href="{{ route('password.request') }}">
                        نسيت كلمة المرور؟
                    </a>
                @endif
            </div>

            <div class="flex items-center justify-between pt-2">
                <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-emerald-600 transition" href="{{ route('register') }}">
                    ليس لديك حساب؟ سجل الآن
                </a>

                <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-lg shadow-sm transition duration-150">
                    تسجيل الدخول
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>