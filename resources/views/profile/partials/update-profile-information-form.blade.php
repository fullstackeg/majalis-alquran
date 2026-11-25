<section dir="rtl" class="text-right">
    <header>
        <h2 class="text-lg font-bold text-gray-900 dark:text-white font-serif">
            معلومات الملف الشخصي
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            قم بتحديث اسمك الكامل في المنصة.
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="الاسم الكامل (بالعربية)" class="text-gray-700 dark:text-gray-300" />
            <x-text-input id="name"
                          name="name"
                          type="text"
                          class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                          :value="old('name', $user->name)"
                          placeholder="مثال: عبد الله محمد الإدريسي"
                          required
                          autofocus
                          autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" value="البريد الإلكتروني" class="text-gray-700 dark:text-gray-300" />
            <input id="email"
                   type="email"
                   value="{{ $user->email }}"
                   disabled
                   readonly
                   class="mt-1 block w-full rounded-md border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800/70 text-gray-500 dark:text-gray-400 cursor-not-allowed text-sm" />
            <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">
                لا يمكن تغيير البريد الإلكتروني المرتبط بالحساب.
            </p>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-lg shadow-sm transition duration-150">
                حفظ التغييرات
            </button>

            @if (session('status') === 'profile-updated')
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