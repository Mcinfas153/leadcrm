<?php

namespace App\Http\Traits;

use Carbon\Carbon;

trait DateTrait{

    public static function getPrevieosDays(int $daysCount): array
    {
        $result = [];
        $start = timeZoneChange(config('custom.LOCAL_TIMEZONE'))->subDay($daysCount);
        for ($i = 0; $i <= $daysCount - 1; $i++) {
            $day = $start->addDay(1)->format('Y-m-d');
            $result[] = $day;
        }

        return $result;
    }
} 