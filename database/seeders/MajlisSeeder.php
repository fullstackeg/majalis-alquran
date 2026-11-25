<?php

namespace Database\Seeders;

use App\Models\Ayah;
use App\Models\Hidayah;
use App\Models\Majlis;
use App\Models\Tadabbur;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MajlisSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate([
            'email' => 'admin@majalis.test',
        ], [
            'name' => 'عبد الله محمد الإدريسي',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        $reader = User::firstOrCreate([
            'email' => 'reader@majalis.test',
        ], [
            'name' => 'قارئ متدبر',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        $member2 = User::firstOrCreate([
            'email' => 'youssef@majalis.test',
        ], [
            'name' => 'يوسف أحمد العلوي',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        $member3 = User::firstOrCreate([
            'email' => 'mariam@majalis.test',
        ], [
            'name' => 'مريم خالد المنصور',
            'password' => bcrypt('password'),
            'is_admin' => false,
        ]);

        $users = [$reader, $member2, $member3, $admin];

        $majalisList = [
            [
                'title' => 'مجلس سورة الفاتحة - آيات الاستفتاح والتعبد',
                'description' => 'دراسة وتدبر لمعاني الفاتحة كما يقررها منهج الإمام الشيخ فريد الأنصاري رحمه الله.',
                'is_published' => true,
                'surah_number' => 1,
                'surah_name' => 'الفاتحة',
                'from_ayah' => 1,
                'to_ayah' => 7,
                'bayan_text' => 'البيان العام: افتتاح السورة بالحمد والاستعانة يربط القلب بالله استحقاقاً ومحبة، ويجعل التوجه إليه أصلاً في كل حال.',
                'tadabburs' => [
                    ['content' => 'وقفة مع حصر العبادة والاستعانة بالله: تحرير للقلب من التعلق بغيره أو الخوف من سواه.', 'status' => 'approved', 'likes_count' => 7],
                    ['content' => 'سؤال الهداية إلى الصراط المستقيم يجمع بين العلم النافع والعمل الصالح في كل ركعة.', 'status' => 'approved', 'likes_count' => 5],
                    ['content' => 'تأمل الجمع بين الرحمة في وصف الربوبية والعدل في ملك يوم الدين.', 'status' => 'pending', 'likes_count' => 0],
                ],
                'hidayat' => [
                    ['content' => 'تجديد نية الإخلاص والاستعانة بالله قبل بدء أي عمل يومي.', 'status' => 'approved', 'votes_count' => 6],
                    ['content' => 'استحضار معاني الفاتحة بتمهل في الصلاة المفروضة.', 'status' => 'pending', 'votes_count' => 0],
                ],
            ],
            [
                'title' => 'مجلس سورة العصر - ميزان الربح والخسران',
                'description' => 'تأمل في شروط النجاة الأربع التي تجمع بين الإيمان والعمل والتواصي بالحق والصبر.',
                'is_published' => true,
                'surah_number' => 103,
                'surah_name' => 'العصر',
                'from_ayah' => 1,
                'to_ayah' => 3,
                'bayan_text' => 'البيان العام: القسم بالزمن يبرز قيمة العمر، ويقرر أن النجاة الحقيقية تقوم على الإيمان والعمل الصالح والتواصي بالحق والصبر.',
                'tadabburs' => [
                    ['content' => 'الإصلاح الفردي لا يكتمل دون التواصي بالحق والصبر داخل الأسرة والمجتمع.', 'status' => 'approved', 'likes_count' => 9],
                    ['content' => 'الزمن وعاء العمل؛ فإما أن يكون شاهداً لنا أو حجة علينا.', 'status' => 'approved', 'likes_count' => 4],
                    ['content' => 'الرفق في التواصي بالحق يجعل النصيحة أقرب إلى القبول.', 'status' => 'rejected', 'likes_count' => 0],
                ],
                'hidayat' => [
                    ['content' => 'مراجعة أثر الوقت اليومي في نهاية كل مساء وتدوين خطوة إصلاح واحدة.', 'status' => 'approved', 'votes_count' => 8],
                    ['content' => 'التواصي بكلمة طيبة مشجعة على الخير مع من حولي.', 'status' => 'approved', 'votes_count' => 3],
                ],
            ],
            [
                'title' => 'مجلس سورة الإخلاص - تجريد التوحيد لله',
                'description' => 'بيان معنى الأحدية والصمدانية لله عز وجل، وتحرير القلب من تعلق المخلوقين.',
                'is_published' => true,
                'surah_number' => 112,
                'surah_name' => 'الإخلاص',
                'from_ayah' => 1,
                'to_ayah' => 4,
                'bayan_text' => 'البيان العام: السورة تقرر التوحيد الخالص لله، وأنه الصمد الذي تقصده الخلائق في حوائجها وتنزه عن الشبيه والنظير.',
                'tadabburs' => [
                    ['content' => 'معنى الصمدية يورث سكينة في القلب لأن المرجع في كل حاجة إلى الغني الحميد.', 'status' => 'approved', 'likes_count' => 11],
                    ['content' => 'تنزيه الله عن المماثلة يرفع الخيال عن تشبيه الخالق بالمخلوق.', 'status' => 'approved', 'likes_count' => 6],
                    ['content' => 'تكرار السورة في الأذكار يرسخ مركزية التوحيد في الوجدان.', 'status' => 'pending', 'likes_count' => 0],
                ],
                'hidayat' => [
                    ['content' => 'تعليق الرجاء والاعتماد القلبي على الله وحده في الأمور الصعبة.', 'status' => 'approved', 'votes_count' => 7],
                    ['content' => 'المحافظة على قراءة السورة في أذكار الصباح والمساء بتدبر.', 'status' => 'approved', 'votes_count' => 4],
                ],
            ],
            [
                'title' => 'مجلس سورة الفلق - الاحتماء برب الفلق',
                'description' => 'الاستعاذة بالله من الشرور الظاهرة والباطنة وتقوية اليقين بحفظ الله لعباده.',
                'is_published' => true,
                'surah_number' => 113,
                'surah_name' => 'الفلق',
                'from_ayah' => 1,
                'to_ayah' => 5,
                'bayan_text' => 'البيان العام: اللجوء إلى الله وحده يعصم القلب من المخاوف والشرور، ويعلم المؤمن أن الحفظ بيد الله.',
                'tadabburs' => [
                    ['content' => 'الاستعاذة بالله تربي النفس على الشجاعة الإيمانية وعدم الاستسلام للقلق.', 'status' => 'approved', 'likes_count' => 5],
                    ['content' => 'الاحتماء برب الفلق يذكرنا بأن انبلاج النور بعد الظلام سنة إلهية.', 'status' => 'pending', 'likes_count' => 0],
                ],
                'hidayat' => [
                    ['content' => 'عدم إغفال المعوذات قبل النوم وبعد الصلوات المكتوبة.', 'status' => 'approved', 'votes_count' => 5],
                ],
            ],
            [
                'title' => 'مجلس سورة الناس - حفظ القلب من الوسواس',
                'description' => 'الاعتصام برب الناس وملكهم وإلههم لدفع وساوس الصدر وتزكية النفس.',
                'is_published' => true,
                'surah_number' => 114,
                'surah_name' => 'الناس',
                'from_ayah' => 1,
                'to_ayah' => 6,
                'bayan_text' => 'البيان العام: تدرج الصفات الإلهية الثلاث (الرب، الملك، الإله) يبني حصناً إيمانياً يحفظ القلب من الوساوس.',
                'tadabburs' => [
                    ['content' => 'الوسواس يضعف حين يستحضر العبد ربوبية الله وملكه وإلهيته معاً.', 'status' => 'approved', 'likes_count' => 8],
                    ['content' => 'الذكر والاستغفار يطردان غبار الخواطر السلبية عن القلب.', 'status' => 'approved', 'likes_count' => 3],
                ],
                'hidayat' => [
                    ['content' => 'الالتجاء إلى الذكر والدعاء فور الشعور بضيق أو وسواس.', 'status' => 'approved', 'votes_count' => 6],
                ],
            ],
            [
                'title' => 'مجلس سورة الكوثر - شكر النعم والإقبال على الله',
                'description' => 'تأمل في سعة العطاء الإلهي وثمرة الشكر بالصلاة والتقرب إلى الله.',
                'is_published' => true,
                'surah_number' => 108,
                'surah_name' => 'الكوثر',
                'from_ayah' => 1,
                'to_ayah' => 3,
                'bayan_text' => 'البيان العام: المنّة الإلهية بالعطاء الوفير تستدعي شكر المنعم بالصلاة والإخلاص، وتبين أن الأثر الباقي لأهل الخير.',
                'tadabburs' => [
                    ['content' => 'الشكر العملي يظهر في الإقبال على الصلاة والبر لا في الكلام المجرد.', 'status' => 'approved', 'likes_count' => 6],
                    ['content' => 'البركة في القليل مع الرضا أعظم من الكثرة بلا شكر.', 'status' => 'pending', 'likes_count' => 0],
                ],
                'hidayat' => [
                    ['content' => 'تدوين ثلاث نعم يومياً وحمد الله عليها قولا وعملا.', 'status' => 'approved', 'votes_count' => 4],
                ],
            ],
            [
                'title' => 'مجلس سورة النصر - التسبيح والاستغفار عند الفتح',
                'description' => 'دروس من ختام السور المدنية حول نسب التوفيق إلى الله ومقابلة النصر بالاستغفار.',
                'is_published' => true,
                'surah_number' => 110,
                'surah_name' => 'النصر',
                'from_ayah' => 1,
                'to_ayah' => 3,
                'bayan_text' => 'البيان العام: التوفيق والفتح من عند الله وحده، وأدب العبد عند تحقق الخير هو التسبيح بحمد الله والاستغفار.',
                'tadabburs' => [
                    ['content' => 'الاستغفار عند إتمام الطاعة والنجاح يحفظ القلب من العجب والغرور.', 'status' => 'approved', 'likes_count' => 10],
                    ['content' => 'تواضع الكبار عند التمكين سر من أسرار استمرار البركة.', 'status' => 'approved', 'likes_count' => 5],
                ],
                'hidayat' => [
                    ['content' => 'الاستغفار والتسبيح عقب إنجاز أي مهمة أو نجاح.', 'status' => 'approved', 'votes_count' => 7],
                ],
            ],
            [
                'title' => 'مجلس سورة قريش - نعمة الأمن والرزق',
                'description' => 'الربط بين نعمتي الأمن والرزق وبين عبادة رب هذا البيت الذي أطعمهم وآمنهم.',
                'is_published' => true,
                'surah_number' => 106,
                'surah_name' => 'قريش',
                'from_ayah' => 1,
                'to_ayah' => 4,
                'bayan_text' => 'البيان العام: الأمن والطمأنينة من أعظم النعم الدنيوية، وشكرهما يكون بعبادة الله وحده والإخلاص له.',
                'tadabburs' => [
                    ['content' => 'قيمة الأمن تظهر حين نتأمل حال من يفتقده، مما يوجب شكر الله عليه.', 'status' => 'approved', 'likes_count' => 4],
                    ['content' => 'تيسير السعي والرزق مرتبط بتقوى الله والالتزام بحدوده.', 'status' => 'pending', 'likes_count' => 0],
                ],
                'hidayat' => [
                    ['content' => 'الدعاء بحفظ الأمن والسكينة للبيوت والمجتمعات.', 'status' => 'approved', 'votes_count' => 3],
                ],
            ],
            [
                'title' => 'مجلس سورة الماعون - حقيقة الدين والرحمة بالخلق',
                'description' => 'التحذير من قسوة القلب والرياء في العمل، والربط بين الصدق في التعبد والرحمة بالضعفاء.',
                'is_published' => true,
                'surah_number' => 107,
                'surah_name' => 'الماعون',
                'from_ayah' => 1,
                'to_ayah' => 7,
                'bayan_text' => 'البيان العام: السورة تكشف التناقض بين مظاهر التدين وبين جفاء القلب عن اليتيم والمسكين والغفلة في الصلاة.',
                'tadabburs' => [
                    ['content' => 'العبادة الحقة تثمر رقة في القلب وعطفاً على المحتاجين.', 'status' => 'approved', 'likes_count' => 9],
                    ['content' => 'مراقبة النفس من الرياء واجبة حتى لا تفرغ الأعمال من روحها.', 'status' => 'approved', 'likes_count' => 6],
                ],
                'hidayat' => [
                    ['content' => 'تفقد محتاج أو مساهمة بسيطة في عمل خيري كل أسبوع.', 'status' => 'approved', 'votes_count' => 8],
                ],
            ],
            [
                'title' => 'مجلس سورة الضحى - البشارة والرعاية الإلهية',
                'description' => 'تثبيت القلب عند بطء الوارد أو اشتداد الابتلاء باستحضار رعاية الله السابقة واللاحقة.',
                'is_published' => true,
                'surah_number' => 93,
                'surah_name' => 'الضحى',
                'from_ayah' => 1,
                'to_ayah' => 11,
                'bayan_text' => 'البيان العام: السورة تبعث الرجاء في النفس وتذكر بأن ما عند الله خير وأبقى، وأن شكر النعمة يكون بالبر والتحدث بها.',
                'tadabburs' => [
                    ['content' => 'تذكر إحسان الله الماضي يطمئن القلب على المستقبل مهما طال الانتظار.', 'status' => 'approved', 'likes_count' => 12],
                    ['content' => 'التحدث بنعمة الله بأدب وشكر يجدد الفرح والرضا في النفس.', 'status' => 'pending', 'likes_count' => 0],
                ],
                'hidayat' => [
                    ['content' => 'الإكثار من الحمد والرجاء في أوقات الفتور أو الضيق.', 'status' => 'approved', 'votes_count' => 9],
                ],
            ],
        ];

        foreach ($majalisList as $index => $data) {
            $baseSlug = Str::slug($data['title'], '-', null) ?: 'majlis';
            $majlis = Majlis::create([
                'user_id' => $admin->id,
                'title' => $data['title'],
                'slug' => $baseSlug . '-' . ($index + 1),
                'description' => $data['description'],
                'is_published' => $data['is_published'],
            ]);

            Ayah::create([
                'majlis_id' => $majlis->id,
                'surah_name' => $data['surah_name'],
                'from_ayah' => $data['from_ayah'],
                'to_ayah' => $data['to_ayah'],
                'quranic_text' => $this->fetchPassageFromApi(
                    $data['surah_number'],
                    $data['surah_name'],
                    $data['from_ayah'],
                    $data['to_ayah']
                ),
                'bayan_text' => $data['bayan_text'],
            ]);

            foreach ($data['tadabburs'] as $tIndex => $tItem) {
                Tadabbur::create([
                    'user_id' => $users[($index + $tIndex) % count($users)]->id,
                    'majlis_id' => $majlis->id,
                    'content' => $tItem['content'],
                    'status' => $tItem['status'],
                    'likes_count' => $tItem['likes_count'],
                ]);
            }

            foreach ($data['hidayat'] as $hIndex => $hItem) {
                Hidayah::create([
                    'user_id' => $users[($index + $hIndex + 1) % count($users)]->id,
                    'majlis_id' => $majlis->id,
                    'content' => $hItem['content'],
                    'status' => $hItem['status'],
                    'votes_count' => $hItem['votes_count'],
                ]);
            }
        }
    }

    private function fetchPassageFromApi(int $surahNumber, string $surahName, int $fromAyah, int $toAyah): string
    {
        try {
            $response = Http::timeout(8)->get("https://api.alquran.cloud/v1/surah/{$surahNumber}/quran-uthmani");

            if ($response->successful()) {
                $ayahs = data_get($response->json(), 'data.ayahs', []);
                $selected = collect($ayahs)
                    ->filter(fn(array $ayah) => ($ayah['numberInSurah'] ?? 0) >= $fromAyah && ($ayah['numberInSurah'] ?? 0) <= $toAyah)
                    ->map(fn(array $ayah) => trim($ayah['text']) . ' (' . $ayah['numberInSurah'] . ')')
                    ->implode(' ');

                if ($selected !== '') {
                    return $selected;
                }
            }
        } catch (\Throwable) {
            // Fall through to descriptive label if network/API is unavailable
        }

        return "سورة {$surahName} (من الآية {$fromAyah} إلى الآية {$toAyah})";
    }
}
