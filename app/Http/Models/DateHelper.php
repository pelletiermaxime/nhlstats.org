<?php

namespace Nhlstats\Http\Models;

use Carbon\Carbon;

class DateHelper
{
    public static function getDates($date) : array
    {
        if ($date !== null && self::validateDate($date)) {
            $todayCarbon = Carbon::createFromFormat('Y-m-d', $date);
            $dates['today'] = $date;
        } else {
            $todayCarbon = Carbon::today();
            $dates['today'] = $todayCarbon->format('Y-m-d');
        }
        $dates['yesterday'] = $todayCarbon->copy()->subDay()->format('Y-m-d');
        $dates['tomorrow'] = $todayCarbon->copy()->addDay()->format('Y-m-d');

        return $dates;
    }

    public static function validateDate($date, $format = 'Y-m-d') : bool
    {
        $validDate = false;
        try {
            // Validation same date after formating.
            // Needed for '2014-05-32' to be invalid...
            // as the formated date would be '2014-06-01'
            $d = Carbon::createFromFormat($format, $date);
            if ($d->format($format) == $date) {
                $validDate = true;
            }
        } catch (Exception $e) {
        }

        return $validDate;
    }
}
