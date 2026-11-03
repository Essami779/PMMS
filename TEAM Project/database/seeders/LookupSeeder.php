<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;
use App\Models\Governorate;
use App\Models\Currency;

class LookupSeeder extends Seeder
{
    public function run(): void
    {
        // 1. العملات وأسعار الصرف (Currencies)
        $currencies = [
            [
                'code' => 'YER',
                'name' => 'الريال اليمني',
                'symbol' => 'ر.ي',
                'flag' => '🇾🇪',
                'color_code' => 'emerald',
                'hex_color' => '#059669',
                'exchange_rate' => 1.0000,
                'is_default' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'code' => 'SAR',
                'name' => 'الريال السعودي',
                'symbol' => 'ر.س',
                'flag' => '🇸🇦',
                'color_code' => 'amber',
                'hex_color' => '#d97706',
                'exchange_rate' => 1.0000,
                'is_default' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'code' => 'USD',
                'name' => 'الدولار الأمريكي',
                'symbol' => '$',
                'flag' => '🇺🇸',
                'color_code' => 'blue',
                'hex_color' => '#2563eb',
                'exchange_rate' => 1.0000,
                'is_default' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'code' => 'EUR',
                'name' => 'اليورو الأوروبي',
                'symbol' => '€',
                'flag' => '🇪🇺',
                'color_code' => 'indigo',
                'hex_color' => '#4f46e5',
                'exchange_rate' => 1.0000,
                'is_default' => false,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'code' => 'AED',
                'name' => 'الدرهم الإماراتي',
                'symbol' => 'د.إ',
                'flag' => '🇦🇪',
                'color_code' => 'teal',
                'hex_color' => '#0d9488',
                'exchange_rate' => 1.0000,
                'is_default' => false,
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'code' => 'OMR',
                'name' => 'الريال العماني',
                'symbol' => 'ر.ع',
                'flag' => '🇴🇲',
                'color_code' => 'purple',
                'hex_color' => '#9333ea',
                'exchange_rate' => 1.0000,
                'is_default' => false,
                'is_active' => true,
                'sort_order' => 6,
            ],
        ];

        foreach ($currencies as $c) {
            Currency::updateOrCreate(['code' => $c['code']], $c);
        }

        // 2. الوحدات والأقسام الإدارية (Units & Departments)
        $units = [
            ['name' => 'الإدارة العامة', 'code' => 'GEN-01', 'color_code' => 'indigo', 'description' => 'المقر الرئيسي والإشراف العام'],
            ['name' => 'إدارة الموارد البشرية', 'code' => 'HR-02', 'color_code' => 'blue', 'description' => 'شؤون الموظفين والتوظيف'],
            ['name' => 'الإدارة المالية والمحاسبة', 'code' => 'FIN-03', 'color_code' => 'emerald', 'description' => 'الشؤون المالية والموازنة'],
            ['name' => 'إدارة تقنية المعلومات', 'code' => 'IT-04', 'color_code' => 'purple', 'description' => 'الدعم الفني والبرمجة والشبكات'],
            ['name' => 'إدارة العلاقات العامة والإعلام', 'code' => 'PR-05', 'color_code' => 'amber', 'description' => 'التواصل والتنسيق والإعلام'],
            ['name' => 'إدارة المتابعة والرقابة', 'code' => 'AUD-06', 'color_code' => 'rose', 'description' => 'التدقيق ومراقبة الجودة والأداء'],
            ['name' => 'إدارة المبيعات والتسويق', 'code' => 'MKT-07', 'color_code' => 'teal', 'description' => 'خدمة العملاء والحملات التسويقية'],
        ];

        foreach ($units as $u) {
            Unit::updateOrCreate(['name' => $u['name']], $u);
        }

        // 3. المحافظات والمناطق الجغرافية (Governorates & Regions)
        $governorates = [
            ['name' => 'أمانة العاصمة', 'code' => 'SNA', 'color_code' => 'indigo'],
            ['name' => 'صنعاء', 'code' => 'SN', 'color_code' => 'blue'],
            ['name' => 'عدن', 'code' => 'ADN', 'color_code' => 'emerald'],
            ['name' => 'تعز', 'code' => 'TAZ', 'color_code' => 'amber'],
            ['name' => 'الحديدة', 'code' => 'HDD', 'color_code' => 'teal'],
            ['name' => 'حضرموت', 'code' => 'HDR', 'color_code' => 'purple'],
            ['name' => 'إب', 'code' => 'IBB', 'color_code' => 'green'],
            ['name' => 'ذمار', 'code' => 'DHM', 'color_code' => 'slate'],
            ['name' => 'مأرب', 'code' => 'MRB', 'color_code' => 'orange'],
            ['name' => 'صعدة', 'code' => 'SAD', 'color_code' => 'rose'],
            ['name' => 'لحج', 'code' => 'LHJ', 'color_code' => 'cyan'],
            ['name' => 'أبين', 'code' => 'ABN', 'color_code' => 'yellow'],
            ['name' => 'شبوة', 'code' => 'SHB', 'color_code' => 'amber'],
            ['name' => 'المهرة', 'code' => 'MHR', 'color_code' => 'violet'],
        ];

        foreach ($governorates as $g) {
            Governorate::updateOrCreate(['name' => $g['name']], $g);
        }
    }
}
