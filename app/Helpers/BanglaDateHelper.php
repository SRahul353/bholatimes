<?php

namespace App\Helpers;

use Carbon\Carbon;

class BanglaDateHelper
{
    public static function getFormattedEPaperDate(Carbon $date)
    {
        $days = ['Sunday'=>'রবিবার','Monday'=>'সোমবার','Tuesday'=>'মঙ্গলবার','Wednesday'=>'বুধবার','Thursday'=>'বৃহস্পতিবার','Friday'=>'শুক্রবার','Saturday'=>'শনিবার'];
        $months = ['Jan'=>'জানুয়ারি','Feb'=>'ফেব্রুয়ারি','Mar'=>'মার্চ','Apr'=>'এপ্রিল','May'=>'মে','Jun'=>'জুন','Jul'=>'জুলাই','Aug'=>'আগস্ট','Sep'=>'সেপ্টেম্বর','Oct'=>'অক্টোবর','Nov'=>'নভেম্বর','Dec'=>'ডিসেম্বর'];
        $enNumbers = ['0','1','2','3','4','5','6','7','8','9'];
        $bnNumbers = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];

        $dayName = $days[$date->format('l')] ?? $date->format('l');

        // English Date (Gregorian) with Bangla suffix
        $enDay = (int)$date->format('d');
        if ($enDay == 1) $enSuffix = 'লা';
        elseif ($enDay == 2 || $enDay == 3) $enSuffix = 'রা';
        elseif ($enDay == 4) $enSuffix = 'ঠা';
        elseif ($enDay >= 5 && $enDay <= 18) $enSuffix = 'ই';
        else $enSuffix = 'শে';
        
        $enMonth = $months[$date->format('M')] ?? $date->format('M');
        $enYear = $date->format('Y');

        $bnDayStr = str_replace($enNumbers, $bnNumbers, (string)$enDay);
        $bnYearStr = str_replace($enNumbers, $bnNumbers, $enYear);
        
        $enDateFormatted = "{$bnDayStr}{$enSuffix} {$enMonth} {$bnYearStr} ইং";

        // Bangla Date (Bangladeshi Revised Calendar)
        $year = (int)$date->format('Y');
        $month = (int)$date->format('n');
        $day = (int)$date->format('j');
        $isLeapYear = ($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0);
        
        $banglaMonths = ["বৈশাখ", "জ্যৈষ্ঠ", "আষাঢ়", "শ্রাবণ", "ভাদ্র", "আশ্বিন", "কার্তিক", "অগ্রহায়ণ", "পৌষ", "মাঘ", "ফাল্গুন", "চৈত্র"];
        $gregDays = [0, 31, $isLeapYear ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        
        $dayOfYear = 0;
        for ($i = 1; $i < $month; $i++) {
            $dayOfYear += $gregDays[$i];
        }
        $dayOfYear += $day;
        
        $boishakhDayOfYear = 31 + ($isLeapYear ? 29 : 28) + 31 + 14; // Boishakh 1 is April 14
        
        if ($dayOfYear >= $boishakhDayOfYear) {
            $bnYearNum = $year - 593;
            $dayOfYear -= $boishakhDayOfYear;
        } else {
            $bnYearNum = $year - 594;
            $prevLeapYear = (($year - 1) % 4 == 0 && ($year - 1) % 100 != 0) || (($year - 1) % 400 == 0);
            $prevYearDays = 365 + ($prevLeapYear ? 1 : 0);
            $lastBoishakhDayOfYear = 31 + ($prevLeapYear ? 29 : 28) + 31 + 14;
            $dayOfYear = $dayOfYear + $prevYearDays - $lastBoishakhDayOfYear;
        }
        
        $monthDays = [31, 31, 31, 31, 31, 30, 30, 30, 30, 30, $isLeapYear ? 31 : 30, 30];
        $accum = 0;
        $bnDayNum = 0;
        $bnMonthIndex = 0;
        for ($i = 0; $i < 12; $i++) {
            if ($dayOfYear < $accum + $monthDays[$i]) {
                $bnDayNum = $dayOfYear - $accum + 1;
                $bnMonthIndex = $i;
                break;
            }
            $accum += $monthDays[$i];
        }
        
        if ($bnDayNum == 1) $bgSuffix = 'লা';
        elseif ($bnDayNum == 2 || $bnDayNum == 3) $bgSuffix = 'রা';
        elseif ($bnDayNum == 4) $bgSuffix = 'ঠা';
        elseif ($bnDayNum >= 5 && $bnDayNum <= 18) $bgSuffix = 'ই';
        else $bgSuffix = 'শে';

        $bgDayStr = str_replace($enNumbers, $bnNumbers, (string)$bnDayNum);
        $bgYearStr = str_replace($enNumbers, $bnNumbers, (string)$bnYearNum);
        
        $bgDateFormatted = "{$bgDayStr}{$bgSuffix} {$banglaMonths[$bnMonthIndex]} {$bgYearStr} বাংলা";

        return "▣ ভোলা : {$dayName} ▣ {$enDateFormatted} ▣ {$bgDateFormatted}";
    }
}
