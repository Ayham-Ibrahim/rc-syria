<?php

namespace Database\Seeders;

use App\Models\ApplicationSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StoreApplicationSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ApplicationSetting::create([
            'name'        => 'تطبيق الهلال الأحمر السوري',
            'logo'        => '/storage/ApplicationSetting/Sarc.png',
            'description' => 'الهلال الأحمر السوري هو منظمة إنسانية غير ربحية تعمل على تقديم المساعدات الإنسانية والإغاثية في سوريا.
            تأسست في عام 1942 وتعمل تحت مبادئ الحركة الدولية للصليب الأحمر والهلال الأحمر.
            تسعى المنظمة إلى التخفيف من معاناة الإنسان وتقديم الخدمات الصحية والاجتماعية في جميع أنحاء سوريا.',
            'facebook'    => 'https://www.facebook.com/syrianredcrescent',
            'youtube'     => 'https://www.youtube.com/channel/UCpSYRNeGfdBBR1ztZAbD2-w',
        ]);
    }
}
