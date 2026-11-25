<section class="space-y-6" dir="rtl" x-data="{ confirmDeleteModal: {{ $errors->userDeletion->isNotEmpty() ? 'true' : 'false' }} }">
    <header>
        <h2 class="text-lg font-bold text-gray-900 dark:text-white font-serif">
            حذف الحساب
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            بمجرد حذف حسابك، سيتم حذف جميع موارده وبياناته نهائياً. يرجى تحميل أي بيانات أو معلومات ترغب في الاحتفاظ بها قبل حذف الحساب.
        </p>
    </header>

    <button type="button"
            x-on:click.prevent="confirmDeleteModal = true"
            class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-semibold text-sm rounded-lg shadow-sm transition duration-150">
        حذف الحساب
    </button>

    <!-- نافذة تأكيد حذف الحساب -->
    <div x-show="confirmDeleteModal"
         x-cloak
         class="relative z-50"
         aria-labelledby="delete-account-modal-title"
         role="dialog"
         aria-modal="true">

        <!-- خلفية ضبابية -->
        <div x-show="confirmDeleteModal"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">

                <div x-show="confirmDeleteModal"
                     x-on:click.outside="confirmDeleteModal = false"
                     x-on:keydown.escape.window="confirmDeleteModal = false"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative transform overflow-hidden rounded-2xl bg-white dark:bg-gray-800 text-right shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-gray-100 dark:border-gray-700">

                    <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-6">
                        @csrf
                        @method('delete')

                        <div class="flex items-start gap-4">
                            <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                            </div>
                            <div>
                                <h2 id="delete-account-modal-title" class="text-lg font-bold text-gray-900 dark:text-white">
                                    هل أنت متأكد من رغبتك في حذف حسابك؟
                                </h2>

                                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                    بمجرد حذف حسابك، سيتم حذف جميع موارده وبياناته نهائياً. يرجى إدخال كلمة المرور لتأكيد رغبتك في حذف الحساب بشكل نهائي.
                                </p>
                            </div>
                        </div>

                        <div>
                            <x-input-label for="password" value="كلمة المرور" class="sr-only" />

                            <x-text-input
                                id="password"
                                name="password"
                                type="password"
                                class="mt-1 block w-full sm:w-3/4 rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                                placeholder="كلمة المرور"
                            />

                            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                        </div>

                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 dark:border-gray-700">
                            <button type="button"
                                    x-on:click="confirmDeleteModal = false"
                                    class="px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-xl text-sm font-semibold transition">
                                إلغاء
                            </button>

                            <button type="submit"
                                    class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-xl text-sm font-semibold transition shadow-sm">
                                حذف الحساب
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>