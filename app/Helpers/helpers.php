<?php
//namespace App\Helpers;

use Carbon\Carbon;

function getDateFormat($dateTime, $format = 'YYYY-MM-DD, h:mm a', $timezone = 'UTC')
{
    $date = Carbon::createFromFormat('Y-m-d H:i:s', $dateTime, config('custom.SERVER_TIMEZONE'));
    $newDate = $date->setTimezone($timezone);
    return $newDate->isoFormat($format);
}

function timeZoneChange($desireTimeZone = 'UTC')
{
    $serverTime =  Carbon::now(config('SERVER_TIMEZONE'));
    $dt = Carbon::parse($serverTime)->tz($desireTimeZone);
    return $dt;
}

function dateFormater($dateTime, $format = 'YYYY-MM-DD, h:mm a')
{
    $date = Carbon::createFromFormat('Y-m-d H:i:s', $dateTime);
    return $date->isoFormat($format);
}

function localTimeConvert(string $desireTimeZone = 'UTC', $dateTime)
{
    $serverTime =  Carbon::parse($dateTime)->tz(config('custom.SERVER_TIMEZONE'));
    $dt = Carbon::parse($serverTime)->tz($desireTimeZone);
    return $dt;
}

function getSrNumberForLeads(int $currentPage, int $perPage, $currentCount): int
{
    $result = ($currentPage === 1)? $currentCount : ($currentPage - 1) * $perPage + $currentCount;
    return $result;
}