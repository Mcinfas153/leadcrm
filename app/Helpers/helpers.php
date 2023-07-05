<?php
use Carbon\Carbon;

function getDateFormat($dateTime, $format = 'YYYY-MM-DD, h:mm a', $timezone = 'UTC')
{
    $date = Carbon::createFromFormat('Y-m-d H:i:s', $dateTime, 'UTC');
    $newDate = $date->setTimezone($timezone);
    return $newDate->isoFormat($format);
}

function getLeadStatusColor($status)
{
    if($status == 'new lead' || $status == 'reshuffle' || $status == "retain"){
        return 'info';
    }else if($status == 'contacted' || $status == 'following up' || $status == 'sent email' || $status == "sent whatsapp" || $status == "call back"){
        return 'warning';
    }else if($status == "setup meeting" || $status == "meeting done" || $status == "site visit"){
        return "success";
    }
}