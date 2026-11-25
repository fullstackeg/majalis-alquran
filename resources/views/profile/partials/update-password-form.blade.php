<section dir="rtl" class="text-right">
    <header>
        <h2 class="text-lg font-bold text-gray-900 dark:text-white font-serif">
            تحديث كلمة المرور
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            تأكد من أن حسابك يستخدم كلمة مرور طويلة وعشوائية للبقاء آمناً.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" value="كلمة المرور الحالية" class="text-gray-700 dark:text-gray-300" />
            <x-text-input id="update_password_current_password"
                          name="current_password"
                          type="password"
                          class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                          autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" value="كلمة المرور الجديدة" class="text-gray-700 dark:text-gray-300" />
            <x-text-input id="update_password_password"
                          name="password"
                          type="password"
                          class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                          autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" value="تأكيد كلمة المرور" class="text-gray-700 dark:text-gray-300" />
            <x-text-input id="update_password_password_confirmation"
                          name="password_confirmation"
                          type="password"
                          class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                          autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-lg shadow-sm transition duration-150">
                حفظ التغييرات
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-600 dark:text-emerald-400 font-medium"
                >تم الحفظ بنجاح.</p>
            @endif
        </div>
    </form>
</section>