<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Majlis;
use App\Models\Ayah;
use App\Models\Tadabbur;
use App\Models\Hidayah;

class MajlisSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إنشاء مستخدم تجريبي (إذا لم يكن موجوداً)
        $user = User::firstOrCreate([
            'email' => 'reader@majalis.test'
        ], [
            'name' => 'قارئ متدبر',
            'password' => bcrypt('password')
        ]);

        // ==========================================
        // المجلس الأول: سورة الفاتحة
        // ==========================================
        $majlis1 = Majlis::create([
            'title' => 'مجلس سورة الفاتحة - آيات الاستفتاح والتعبد',
            'description' => 'دراسة وتدبر لمعاني الفاتحة كما يقررها منهج الإمام الشيخ فريد الأنصاري رحمه الله.',
            'is_published' => true,
        ]);

        Ayah::create([
            'majlis_id' => $majlis1->id,
            'surah_name' => 'الفاتحة',
            'from_ayah' => 1,
            'to_ayah' => 5,
            'quranic_text' => 'بِسْمِ اللَّهِ الرَّحْمَٰنِ الرَّحِيمِ (1) الْحَمْدُ لِلَّهِ رَبِّ الْعَالَمِينَ (2) الرَّحْمَٰنِ الرَّحِيمِ (3) مَالِكِ يَوْمِ الدِّينِ (4) إِيَّاكَ نَعْبُدُ وَإِيَّاكَ نَسْتَعِينُ (5)',
            'bayan_text' => 'البيان العام: افتتاح السورة بالبسملة والحمد يعلمنا تعلق القلب بالله استحقاقاً وحباً، وتفريد العبادة والاستعانة يحرر العبد من عبودية سوى الله.',
        ]);

        Tadabbur::create([
            'user_id' => $user->id,
            'majlis_id' => $majlis1->id,
            'content' => 'وقفة مع "إياك نعبد": تقديم المعمول (إياك) يفيد الحصر، فلا تعلق القلب بغيره ولا ترجو سواه.',
            'status' => 'approved',
            'likes_count' => 5,
        ]);

        Hidayah::create([
            'user_id' => $user->id,
            'majlis_id' => $majlis1->id,
            'content' => 'تجديد العهد مع الله في كل صلاة بأن تكون الاستعانة خالصة له وحده في كل شؤون اليوم.',
            'status' => 'approved',
            'votes_count' => 3,
        ]);

        // ==========================================
        // المجلس الثاني: سورة الإخلاص (جديد)
        // ==========================================
        $majlis2 = Majlis::create([
            'title' => 'مجلس سورة الإخلاص - تجريد التوحيد لله',
            'description' => 'بيان معنى الأحدية والصَمَدانية لله عز وجل، وتحرير القلب من تعلق المخلوقين.',
            'is_published' => true,
        ]);

        Ayah::create([
            'majlis_id' => $majlis2->id,
            'surah_name' => 'الإخلاص',
            'from_ayah' => 1,
            'to_ayah' => 4,
            'quranic_text' => 'قُلْ هُوَ اللَّهُ أَحَدٌ (1) اللَّهُ الصَّمَدُ (2) لَمْ يَلِدْ وَلَمْ يُولَدْ (3) وَلَمْ يَكُن لَّهُ كُفُوًا أَحَدٌ (4)',
            'bayan_text' => 'البيان العام: السورة تقرر أصل التوحيد الخالص لله تعالى، وأنه الصمد الذي تصمد إليه الخلائق في حاجاتها، وتنقض كل أشكال الشرك والارتباط العبدي بغيره.',
        ]);

        Tadabbur::create([
            'user_id' => $user->id,
            'majlis_id' => $majlis2->id,
            'content' => 'معية "الصمد": حين تعلم أن الله هو الصمد وحده الذي تُقصد الحاجات إليه، ترتاح النفس من الذل للمخلوقين.',
            'status' => 'approved',
            'likes_count' => 8,
        ]);

        Hidayah::create([
            'user_id' => $user->id,
            'majlis_id' => $majlis2->id,
            'content' => 'الاعتماد القلبي على الله وحده في قضاء الحوائج، وتدبر معاني الأحدية في كل دعاء.',
            'status' => 'approved',
            'votes_count' => 6,
        ]);
    }
}