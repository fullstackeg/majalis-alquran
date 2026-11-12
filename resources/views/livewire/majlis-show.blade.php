<div class="py-12" dir="rtl">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- رأس المجلس -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">{{ $majlis->title }}</h1>
            <p class="text-gray-600 dark:text-gray-300 text-sm">{{ $majlis->description }}</p>
        </div>

        <!-- رسالة النجاح -->
        @if (session()->has('message'))
            <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 rounded-lg text-sm">
                {{ session('message') }}
            </div>
        @endif

        <!-- عرض الآيات والبيان العام -->
        @foreach($majlis->ayat as $ayah)
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 space-y-4">
                <div class="text-emerald-600 dark:text-emerald-400 font-semibold text-sm">
                    سورة {{ $ayah->surah_name }} (من آية {{ $ayah->from_ayah }} إلى {{ $ayah->to_ayah }})
                </div>
                
                <div class="p-4 bg-emerald-50/50 dark:bg-emerald-900/10 rounded-lg text-lg leading-loose font-serif text-gray-800 dark:text-gray-200 text-center">
                    {{ $ayah->quranic_text }}
                </div>

                <div class="border-t border-gray-100 dark:border-gray-700 pt-4">
                    <h3 class="font-bold text-gray-800 dark:text-gray-200 mb-2">البيان العام (التدبر التأسيسي):</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
                        {{ $ayah->bayan_text }}
                    </p>
                </div>
            </div>
        @endforeach

        <!-- نموذج إضافة تدبر جديد -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">أضف تدبرك الإيماني لهذا المجلس</h3>
            
            @auth
                <form wire:submit="storeTadabbur" class="space-y-4">
                    <div>
                        <textarea wire:model="content" rows="4" 
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                                placeholder="اكتب المعنى الإيماني أو السلوك المستنبط من الآيات..."></textarea>
                        @error('content') 
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>

                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-md transition duration-150">
                        إرسال التدبر للمراجعة
                    </button>
                </form>
            @else
                <div class="text-center py-6 bg-gray-50 dark:bg-gray-700/30 rounded-lg border border-gray-100 dark:border-gray-700">
                    <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm">يجب عليك تسجيل الدخول لتتمكن من مشاركة تدبراتك مع المجتمع.</p>
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white transition">
                        تسجيل الدخول
                    </a>
                </div>
            @endauth
        </div>

        <!-- تدبرات القراء -->
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 space-y-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-3">
                تدبرات القراء ({{ $majlis->tadabburat->count() }})
            </h3>

            <div class="space-y-4">
                @forelse($majlis->tadabburat as $tadabbur)
                    @php
                        // التحقق مما إذا كان المستخدم الحالي قد أُعجب بهذا التدبر
                        $hasLiked = $tadabbur->likes->where('user_id', auth()->id())->isNotEmpty();
                    @endphp
                    <div class="p-4 bg-gray-50 dark:bg-gray-700/30 rounded-lg border border-gray-100 dark:border-gray-700">
                        <p class="text-gray-800 dark:text-gray-200 text-sm mb-3">{{ $tadabbur->content }}</p>
                        <div class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-400">
                            <span>بقلم: {{ $tadabbur->user->name }}</span>
                            
                            <!-- زر الإعجاب التفاعلي -->
                            <button wire:click="toggleLike({{ $tadabbur->id }})" 
                                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full transition {{ $hasLiked ? 'bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 hover:bg-gray-300' }}">
                                <span>{{ $hasLiked ? '❤️' : '🤍' }}</span>
                                <span class="font-semibold">{{ $tadabbur->likes->count() }}</span>
                            </button>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 dark:text-gray-400 text-sm">لا توجد تدبرات منشورة بعد. كن أول المتدبرين!</p>
                @endforelse
            </div>
        </div>

        <!-- قسم الهدايات والسلوك المستنبط -->
<div class="mt-12 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 space-y-6">
    <h3 class="text-lg font-bold text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-700 pb-3">
        الهدايات والسلوك المستنبط ({{ $majlis->hidayat->count() }})
    </h3>

    @if (session()->has('hidayat_message'))
        <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-300 rounded-lg text-sm">
            {{ session('hidayat_message') }}
        </div>
    @endif

    <!-- عرض الهدايات المنشورة -->
    <div class="space-y-4">
        @forelse($majlis->hidayat as $hidayah)
            <div class="p-4 bg-gray-50 dark:bg-gray-700/30 rounded-lg border border-gray-100 dark:border-gray-700">
                <p class="text-gray-800 dark:text-gray-200 text-sm mb-2 leading-relaxed">{{ $hidayah->content }}</p>
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    بقلم: {{ $hidayah->user->name }} • {{ \Carbon\Carbon::parse($hidayah->created_at)->locale('ar')->diffForHumans() }}
                </div>
            </div>
        @empty
            <p class="text-gray-500 dark:text-gray-400 text-sm">لا توجد هدايات منشورة بعد في هذا المجلس.</p>
        @endforelse
    </div>

    <!-- نموذج إضافة هداية جديدة -->
    <div class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
        <h4 class="font-bold text-gray-800 dark:text-gray-200 mb-3 text-sm">أضف هداية أو سلوكاً عملياً مستنبطاً</h4>
            @auth
                <form wire:submit="storeHidayat" class="space-y-4">
                    <div>
                        <textarea wire:model="newHidayatContent" rows="3" 
                                class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm"
                                placeholder="اكتب هداية عملية أو سلوكاً إيمانيّاً تستنبطه من الآيات..."></textarea>
                        @error('newHidayatContent') 
                            <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> 
                        @enderror
                    </div>
                    <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm rounded-md transition">
                        إرسال الهداية للمراجعة
                    </button>
                </form>
            @else
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    يرجى <a href="{{ route('login') }}" class="text-emerald-600 hover:underline">تسجيل الدخول</a> لتتمكن من مشاركة الهدايات.
                </p>
            @endauth
        </div>
    </div>

    </div>
</div>