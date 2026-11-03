<?php

if (!function_exists('numberToArabicWords')) {
    function numberToArabicWords($number)
    {
        $hyphen      = ' و ';
        $conjunction = ' و ';
        $separator   = ' و ';
        $negative    = 'سالب ';
        $decimal     = ' فاصلة ';
        $fraction    = '';
        $dictionary  = array(
            0                   => 'صفر',
            1                   => 'واحد',
            2                   => 'اثنان',
            3                   => 'ثلاثة',
            4                   => 'أربعة',
            5                   => 'خمسة',
            6                   => 'ستة',
            7                   => 'سبعة',
            8                   => 'ثمانية',
            9                   => 'تسعة',
            10                  => 'عشرة',
            11                  => 'أحد عشر',
            12                  => 'اثنا عشر',
            13                  => 'ثلاثة عشر',
            14                  => 'أربعة عشر',
            15                  => 'خمسة عشر',
            16                  => 'ستة عشر',
            17                  => 'سبعة عشر',
            18                  => 'ثمانية عشر',
            19                  => 'تسعة عشر',
            20                  => 'عشرون',
            30                  => 'ثلاثون',
            40                  => 'أربعون',
            50                  => 'خمسون',
            60                  => 'ستون',
            70                  => 'سبعون',
            80                  => 'ثمانون',
            90                  => 'تسعون',
            100                 => 'مائة',
            200                 => 'مئتان',
            300                 => 'ثلاثمائة',
            400                 => 'أربعمائة',
            500                 => 'خمسمائة',
            600                 => 'ستمائة',
            700                 => 'سبعمائة',
            800                 => 'ثمانمائة',
            900                 => 'تسعمائة',
            1000                => 'ألف',
            2000                => 'ألفان',
            3000                => 'آلاف',
            1000000             => 'مليون',
            2000000             => 'مليونان',
            3000000             => 'ملايين',
            1000000000          => 'مليار',
            2000000000          => 'ملياران',
            3000000000          => 'مليارات',
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
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string = $dictionary[$units] . $hyphen . $string;
                }
                break;
            case $number < 1000:
                $hundreds  = $number - ($number % 100);
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




    // ======================================= Month

}
