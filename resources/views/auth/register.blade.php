<x-guest-layout>
    <div dir="rtl" class="text-right">
        
        <!-- عنوان الصفحة -->
        <div class="mb-6 text-center">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white font-serif">إنشاء حساب جديد</h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">انضم إلينا وشاركنا تدبراتك ومجالس الذكر</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" value="الاسم الكامل (بالعربية)" class="text-gray-700 dark:text-gray-300" />
                <x-text-input id="name" 
                            class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm" 
                            type="text" 
                            name="name" 
                            :value="old('name')" 
                            placeholder="مثال: عبد الله محمد الإدريسي"
                            required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label for="email" value="البريد الإلكتروني" class="text-gray-700 dark:text-gray-300" />
                <x-text-input id="email" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" value="كلمة المرور" class="text-gray-700 dark:text-gray-300" />
                <x-text-input id="password" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" value="تأكيد كلمة المرور" class="text-gray-700 dark:text-gray-300" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                                type="password"
                                name="password_confirmation"
                                required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-between pt-2">
                <a class="text-sm text-gray-600 dark:text-gray-400 hover:text-emerald-600 transition" href="{{ route('login') }}">
                    لديك حساب بالفعل؟ سجل دخولك
                </a>

                <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-lg shadow-sm transition duration-150">
                    إتمام التسجيل
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>