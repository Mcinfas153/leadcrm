<?php
use Carbon\Carbon;

function getDateFormat($dateTime, $format = 'YYYY-MM-DD, h:mm a', $timezone = 'UTC')
{
    $date = Carbon::createFromFormat('Y-m-d H:i:s', $dateTime, 'UTC');
    $newDate = $date->setTimezone($timezone);
    return $newDate->isoFormat($format);
}

function timeZoneChange($desireTimeZone = 'UTC')
{
    $serverTime =  Carbon::now(config('SERVER_TIMEZONE'));
    $dt = Carbon::parse($serverTime)->tz($desireTimeZone);
    return $dt;
}