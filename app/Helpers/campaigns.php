<?php

use Carbon\Carbon;

function campaignStatus(string $dateTime)
{
    $result = [];
    $result = Carbon::now()->tz(config('custom.LOCAL_TIMEZONE'))->diffInHours(Carbon::parse($dateTime));
    return $result;
}