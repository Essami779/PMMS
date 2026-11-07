<?php

use App\Services\HijriDateService;

if (!function_exists('hijri_date')) {
    /**
     * تحويل تاريخ إلى هجري
     */
    function hijri_date($date): string
    {
        if (!$date) {
            return '—';
        }
        $hijri = HijriDateService::gregorianToHijri($date);
        return $hijri ? $hijri['formatted'] : '—';
    }
}

if (!function_exists('dual_date')) {
    /**
     * إرجاع التنسيق المزدوج للتاريخ (ميلادي وهجري)
     */
    function dual_date($date, string $format = 'Y/m/d'): string
    {
        return HijriDateService::formatDual($date, $format);
    }
}

if (!function_exists('gregorian_month_name')) {
    /**
     * اسم الشهر الميلادي بالعربية
     */
    function gregorian_month_name(int $month): string
    {
        return HijriDateService::$gregorianMonths[$month] ?? '';
    }
}

if (!function_exists('hijri_month_name')) {
    /**
     * اسم الشهر الهجري بالعربية
     */
    function hijri_month_name(int $month): string
    {
        return HijriDateService::$hijriMonths[$month] ?? '';
    }
}

if (!function_exists('report_period_label')) {
    /**
     * توليد تسمية الفترة الزمنية للتقرير بناءً على معاملات الفلترة.
     *
     * القاعدة المعتمدة (حسب طلب المستخدم):
     * - عند تحديد نطاق تواريخ جزئي (من تاريخ إلى تاريخ يختلفان) => الأولوية لإظهار "من.. إلى..".
     * - لا يظهر اسم الشهر إلا إذا كان النطاق شهراً كاملاً (من أول الشهر إلى آخره)،
     *   أو عند اختيار شهر من قائمة الشهور فقط.
     *
     * @param array $params معاملات اختيارية: date_from, date_to, filter_month, filter_year, cal_type, default
     */
    function report_period_label(array $params = []): string
    {
        $read = function (string $key, $default = null) use ($params) {
            if (array_key_exists($key, $params)) {
                return $params[$key];
            }
            return function_exists('request') ? request($key, $default) : $default;
        };

        $dateFrom = $read('date_from');
        $dateTo = $read('date_to');
        $filterMonth = $read('filter_month');
        $filterYear = $read('filter_year');
        $calType = $read('cal_type', 'gregorian');
        $isHijri = $calType === 'hijri';

        // استخراج أوتوماتيكي للتاريخين من المجموعة إن لم يُحددا في الطلب
        if (!$dateFrom && !$dateTo) {
            $records = $params['collection'] ?? $params['records'] ?? null;
            if ($records && is_iterable($records)) {
                $coll = collect($records);
                if ($coll->isNotEmpty()) {
                    $rawMin = $coll->min('created_at');
                    $rawMax = $coll->max('created_at');
                    if ($rawMin && $rawMax) {
                        $dateFrom = \Carbon\Carbon::parse($rawMin)->format('Y-m-d');
                        $dateTo = \Carbon\Carbon::parse($rawMax)->format('Y-m-d');
                    }
                }
            }
        }

        $arabicMonths = HijriDateService::$gregorianMonths ?? [];
        $hijriMonths = HijriDateService::$hijriMonths ?? [];

        // 1) نطاق تواريخ صريح (date_from و date_to معاً)
        if ($dateFrom && $dateTo) {
            $hF = HijriDateService::gregorianToHijri($dateFrom);
            $hT = HijriDateService::gregorianToHijri($dateTo);

            $hFStr = ($hF['day'] ?? '') . ' ' . ($hF['month_name'] ?? '') . ' ' . ($hF['year'] ?? '') . 'هـ';
            $hTStr = ($hT['day'] ?? '') . ' ' . ($hT['month_name'] ?? '') . ' ' . ($hT['year'] ?? '') . 'هـ';
            $gFStr = \Carbon\Carbon::parse($dateFrom)->format('Y/m/d') . 'م';
            $gTStr = \Carbon\Carbon::parse($dateTo)->format('Y/m/d') . 'م';

            // تاريخ واحد فقط
            if ($dateFrom === $dateTo) {
                return $isHijri
                    ? '<span class="period-txt">بتاريخ:</span> <span class="period-date-hijri">' . $hFStr . '</span> <span class="period-bracket">(الموافق</span> <span class="period-date-greg">' . $gFStr . '</span><span class="period-bracket">)</span>'
                    : '<span class="period-txt">بتاريخ:</span> <span class="period-date-greg">' . $gFStr . '</span> <span class="period-bracket">(الموافق</span> <span class="period-date-hijri">' . $hFStr . '</span><span class="period-bracket">)</span>';
            }

            // هل النطاق يغطي شهراً كاملاً (من أول الشهر إلى آخره)؟
            $isFullMonth = false;
            if ($isHijri) {
                // الشهر كامل: البداية يوم 1 من شهر هجري، والنهاية آخر يوم في نفس الشهر،
                // واليوم التالي للنهاية يقع في شهر/سنة مختلفة.
                $hFday = (int) ($hF['day'] ?? 0);
                $hFmon = (int) ($hF['month'] ?? 0);
                $hFyr = (int) ($hF['year'] ?? 0);
                $hTmon = (int) ($hT['month'] ?? 0);
                $hTyr = (int) ($hT['year'] ?? 0);
                $nextDay = \Carbon\Carbon::parse($dateTo)->addDay()->toDateString();
                $hNext = HijriDateService::gregorianToHijri($nextDay);
                $isEndOfMonth = (($hNext['month'] ?? null) !== $hTmon) || (($hNext['year'] ?? null) !== $hTyr);
                if ($hFday === 1 && $hFmon === $hTmon && $hFyr === $hTyr && $isEndOfMonth) {
                    $isFullMonth = true;
                }
            } else {
                $dF = \Carbon\Carbon::parse($dateFrom);
                $dT = \Carbon\Carbon::parse($dateTo);
                if (
                    $dF->day === 1 &&
                    $dF->format('Y-m') === $dT->format('Y-m') &&
                    $dT->day === $dF->copy()->endOfMonth()->day
                ) {
                    $isFullMonth = true;
                }
            }

            if ($isFullMonth) {
                if ($isHijri) {
                    return '<span class="period-txt">لشهر:</span> <span class="period-date-hijri">' . ($hF['month_name'] ?? '') . ' ' . ($hF['year'] ?? '') . 'هـ</span>';
                }
                $dF = \Carbon\Carbon::parse($dateFrom);
                return '<span class="period-txt">لشهر:</span> <span class="period-date-greg">' . ($arabicMonths[(int) $dF->format('m')] ?? '') . ' ' . $dF->format('Y') . 'م</span>';
            }

            // نطاق جزئي — إظهار الميلادي والهجري معاً كما طلب المستخدم
            return $isHijri
                ? '<span class="period-txt">للفترة من</span> <span class="period-date-hijri">' . $hFStr . '</span> <span class="period-txt">إلى</span> <span class="period-date-hijri">' . $hTStr . '</span> <span class="period-bracket">(الموافق من</span> <span class="period-date-greg">' . $gFStr . '</span> <span class="period-txt">إلى</span> <span class="period-date-greg">' . $gTStr . '</span><span class="period-bracket">)</span>'
                : '<span class="period-txt">للفترة من</span> <span class="period-date-greg">' . $gFStr . '</span> <span class="period-txt">إلى</span> <span class="period-date-greg">' . $gTStr . '</span> <span class="period-bracket">(الموافق من</span> <span class="period-date-hijri">' . $hFStr . '</span> <span class="period-txt">إلى</span> <span class="period-date-hijri">' . $hTStr . '</span><span class="period-bracket">)</span>';
        }

        // 2) تاريخ بداية فقط
        if ($dateFrom) {
            $gFStr = \Carbon\Carbon::parse($dateFrom)->format('Y/m/d') . 'م';
            $hF = HijriDateService::gregorianToHijri($dateFrom);
            $hFStr = ($hF['day'] ?? '') . ' ' . ($hF['month_name'] ?? '') . ' ' . ($hF['year'] ?? '') . 'هـ';
            return $isHijri
                ? '<span class="period-txt">من تاريخ:</span> <span class="period-date-hijri">' . $hFStr . '</span> <span class="period-bracket">(الموافق</span> <span class="period-date-greg">' . $gFStr . '</span><span class="period-bracket">)</span>'
                : '<span class="period-txt">من تاريخ:</span> <span class="period-date-greg">' . $gFStr . '</span> <span class="period-bracket">(الموافق</span> <span class="period-date-hijri">' . $hFStr . '</span><span class="period-bracket">)</span>';
        }

        // 3) تاريخ نهاية فقط
        if ($dateTo) {
            $gTStr = \Carbon\Carbon::parse($dateTo)->format('Y/m/d') . 'م';
            $hT = HijriDateService::gregorianToHijri($dateTo);
            $hTStr = ($hT['day'] ?? '') . ' ' . ($hT['month_name'] ?? '') . ' ' . ($hT['year'] ?? '') . 'هـ';
            return $isHijri
                ? '<span class="period-txt">حتى تاريخ:</span> <span class="period-date-hijri">' . $hTStr . '</span> <span class="period-bracket">(الموافق</span> <span class="period-date-greg">' . $gTStr . '</span><span class="period-bracket">)</span>'
                : '<span class="period-txt">حتى تاريخ:</span> <span class="period-date-greg">' . $gTStr . '</span> <span class="period-bracket">(الموافق</span> <span class="period-date-hijri">' . $hTStr . '</span><span class="period-bracket">)</span>';
        }

        // 4) اختيار شهر من القائمة (بدون نطاق تواريخ صريح)
        if ($filterMonth) {
            $mInt = (int) $filterMonth;
            if ($isHijri) {
                $yVal = $filterYear ?: HijriDateService::currentHijriYear();
                return '<span class="period-txt">لشهر:</span> <span class="period-date-hijri">' . ($hijriMonths[$mInt] ?? '') . ' ' . $yVal . 'هـ</span>';
            }
            $yVal = $filterYear ?: now()->year;
            return '<span class="period-txt">لشهر:</span> <span class="period-date-greg">' . ($arabicMonths[$mInt] ?? '') . ' ' . $yVal . 'م</span>';
        }

        // 5) سنة فقط
        if ($filterYear) {
            return '<span class="period-txt">لعام:</span> <span class="' . ($isHijri ? 'period-date-hijri' : 'period-date-greg') . '">' . $filterYear . ($isHijri ? 'هـ' : 'م') . '</span>';
        }

        // 6) القيمة الافتراضية
        return $params['default'] ?? 'تقرير شامل لكافة السجلات';
    }
}



// ======= المبلغ كتابة ======


if (!function_exists('numberToArabicWords')) {
    function numberToArabicWords($number)
    {
        $hyphen = ' و ';
        $conjunction = ' و ';
        $separator = ' و ';
        $negative = 'سالب ';
        $decimal = ' فاصلة ';
        $fraction = '';
        $dictionary = array(
            0 => 'صفر',
            1 => 'واحد',
            2 => 'اثنان',
            3 => 'ثلاثة',
            4 => 'أربعة',
            5 => 'خمسة',
            6 => 'ستة',
            7 => 'سبعة',
            8 => 'ثمانية',
            9 => 'تسعة',
            10 => 'عشرة',
            11 => 'أحد عشر',
            12 => 'اثنا عشر',
            13 => 'ثلاثة عشر',
            14 => 'أربعة عشر',
            15 => 'خمسة عشر',
            16 => 'ستة عشر',
            17 => 'سبعة عشر',
            18 => 'ثمانية عشر',
            19 => 'تسعة عشر',
            20 => 'عشرون',
            30 => 'ثلاثون',
            40 => 'أربعون',
            50 => 'خمسون',
            60 => 'ستون',
            70 => 'سبعون',
            80 => 'ثمانون',
            90 => 'تسعون',
            100 => 'مائة',
            200 => 'مئتان',
            300 => 'ثلاثمائة',
            400 => 'أربعمائة',
            500 => 'خمسمائة',
            600 => 'ستمائة',
            700 => 'سبعمائة',
            800 => 'ثمانمائة',
            900 => 'تسعمائة',
            1000 => 'ألف',
            2000 => 'ألفان',
            3000 => 'آلاف',
            1000000 => 'مليون',
            2000000 => 'مليونان',
            3000000 => 'ملايين',
            1000000000 => 'مليار',
            2000000000 => 'ملياران',
            3000000000 => 'مليارات',
        );

        if ($number < 0) {
            return $negative . numberToArabicWords(abs($number));
        }

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string = $dictionary[$units] . $hyphen . $string;
                }
                break;
            case $number < 1000:
                $hundreds = $number - ($number % 100);
                $remainder = $number % 100;
                $string = $dictionary[$hundreds];
                if ($remainder) {
                    $string .= $conjunction . numberToArabicWords($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;

                $string = numberToArabicWords($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= numberToArabicWords($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }
}

if (!function_exists('system_currencies')) {
    /**
     * الحصول على جميع العملات النشطة في النظام مع هوياتها البصرية
     */
    function system_currencies()
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('currencies')) {
                return \App\Models\Currency::active()->get();
            }
        } catch (\Throwable $e) {}

        return collect([
            (object)['code' => 'YER', 'name' => 'الريال اليمني', 'symbol' => 'ريال', 'flag' => '🇾🇪', 'color_code' => 'emerald', 'hex_color' => '#059669', 'badge_class' => 'bg-emerald-50 text-emerald-700 border-emerald-300'],
            (object)['code' => 'SAR', 'name' => 'الريال السعودي', 'symbol' => 'ر.س', 'flag' => '🇸🇦', 'color_code' => 'amber', 'hex_color' => '#d97706', 'badge_class' => 'bg-amber-50 text-amber-700 border-amber-300'],
            (object)['code' => 'USD', 'name' => 'الدولار الأمريكي', 'symbol' => '$', 'flag' => '🇺🇸', 'color_code' => 'blue', 'hex_color' => '#2563eb', 'badge_class' => 'bg-blue-50 text-blue-700 border-blue-300'],
        ]);
    }
}

if (!function_exists('currency_meta')) {
    /**
     * استرجاع البيانات البصرية والهوية الكاملة لعملة محددة
     */
    function currency_meta($code = 'YER')
    {
        $code = strtoupper(trim($code ?: 'YER'));
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('currencies')) {
                $curr = \App\Models\Currency::where('code', $code)->first();
                if ($curr) {
                    return $curr;
                }
            }
        } catch (\Throwable $e) {}

        return match ($code) {
            'SAR' => (object)['code' => 'SAR', 'name' => 'الريال السعودي', 'symbol' => 'ر.س', 'flag' => '🇸🇦', 'color_code' => 'amber', 'hex_color' => '#d97706', 'badge_class' => 'bg-amber-50 text-amber-700 border-amber-300', 'full_label' => '🇸🇦 الريال السعودي (SAR)'],
            'USD' => (object)['code' => 'USD', 'name' => 'الدولار الأمريكي', 'symbol' => '$', 'flag' => '🇺🇸', 'color_code' => 'blue', 'hex_color' => '#2563eb', 'badge_class' => 'bg-blue-50 text-blue-700 border-blue-300', 'full_label' => '🇺🇸 الدولار الأمريكي (USD)'],
            'EUR' => (object)['code' => 'EUR', 'name' => 'اليورو الأوروبي', 'symbol' => '€', 'flag' => '🇪🇺', 'color_code' => 'indigo', 'hex_color' => '#4f46e5', 'badge_class' => 'bg-indigo-50 text-indigo-700 border-indigo-300', 'full_label' => '🇪🇺 اليورو الأوروبي (EUR)'],
            'AED' => (object)['code' => 'AED', 'name' => 'الدرهم الإماراتي', 'symbol' => 'د.إ', 'flag' => '🇦🇪', 'color_code' => 'teal', 'hex_color' => '#0d9488', 'badge_class' => 'bg-teal-50 text-teal-700 border-teal-300', 'full_label' => '🇦🇪 الدرهم الإماراتي (AED)'],
            'OMR' => (object)['code' => 'OMR', 'name' => 'الريال العماني', 'symbol' => 'ر.ع', 'flag' => '🇴🇲', 'color_code' => 'purple', 'hex_color' => '#9333ea', 'badge_class' => 'bg-purple-50 text-purple-700 border-purple-300', 'full_label' => '🇴🇲 الريال العماني (OMR)'],
            default => (object)['code' => 'YER', 'name' => 'الريال اليمني', 'symbol' => 'ريال', 'flag' => '🇾🇪', 'color_code' => 'emerald', 'hex_color' => '#059669', 'badge_class' => 'bg-emerald-50 text-emerald-700 border-emerald-300', 'full_label' => '🇾🇪 الريال اليمني (YER)'],
        };
    }
}

if (!function_exists('tafqeet')) {
    /**
     * تحويل الأرقام إلى تفقيط باللغة العربية مع العملة واللواحق
     */
    function tafqeet($number, $currency = null, $suffix = 'فقط لا غير')
    {
        $num = (float) $number;
        $words = numberToArabicWords($num);

        // Resolve currency name
        $currencyName = 'ريال يمني';
        if ($currency instanceof \App\Models\Currency) {
            $currencyName = $currency->name;
        } elseif (is_string($currency) && !empty($currency)) {
            if (in_array(strtoupper(trim($currency)), ['YER', 'SAR', 'USD', 'EUR', 'AED', 'OMR', 'QAR', 'KWD'])) {
                $meta = currency_meta($currency);
                $currencyName = $meta->name ?? $currency;
            } else {
                $currencyName = $currency;
            }
        }

        if (empty($words) || $words === 'صفر') {
            $currencyClean = preg_replace('/^ال/u', '', $currencyName);
            $currencyClean = preg_replace('/(\s+)ال/u', '$1', $currencyClean);
            return 'صفر ' . $currencyClean . ($suffix ? ' ' . $suffix : '');
        }

        // Clean currency name to indefinite form for natural Arabic reading (e.g. "ريال يمني" instead of "الريال اليمني")
        $currencyClean = preg_replace('/^ال/u', '', $currencyName);
        $currencyClean = preg_replace('/(\s+)ال/u', '$1', $currencyClean);

        return trim('فقط وقدره ' . $words . ' ' . $currencyClean . ($suffix ? ' ' . $suffix : '.'));
    }
}
