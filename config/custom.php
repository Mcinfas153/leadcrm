<?php

return [
    'USER_SUPERADMIN' => 1,
    'USER_ADMIN' => 2,
    'USER_NORMAL' => 3,
    'USER_SUPERADMIN_ROLE' => 1,
    'USER_ADMIN_ROLE' => 2,
    'USER_AGENT_ROLE' => 3,
    'LEAD_TYPE_FRESH' => 1,
    'LEAD_TYPE_HOT' => 2,
    'LEAD_TYPE_COLD' => 3,
    'LEAD_STATUS_NEW' => 1,
    'LEAD_STATUS_FOLLOWINGUP' => 7,
    'LEAD_STATUS_SENT_EMAIL' => 8,
    'LEAD_STATUS_SENT_WHATSAPP' => 9,
    'LEAD_STATUS_SITE_VISIT' => 10,
    'LEAD_STATUS_SETUP_MEETING' => 11,
    'LEAD_STATUS_MEETING_DONE' => 13,
    'LEAD_STATUS_NOT_INTERESTED' => 16,
    'LEAD_STATUS_NOT_QUALIFIED' => 17,
    'LEAD_STATUS_JUNK_LEAD' => 19,
    'LEAD_STATUS_SITE_VISIT_DONE' => 21,
    'LEAD_STATUS_FOLLOWUP_AFTER_MEETING' => 22,
    'LEAD_STATUS_DEAL_CLOSED' => 18,
    'ACTION_LOGIN' => 1,
    'ACTION_OPEN_LEAD' => 3,
    'ACTION_EDIT_LEAD' => 4,
    'ACTION_DELETE_LEAD' => 6,
    'ACTION_CHANGE_STATUS' => 10,
    'ACTION_ASSIGN_USER' => 11,
    'ACTION_ADD_NOTE' => 13,
    'ACTION_DELETE_NOTE' => 14,
    'ACTION_ADD_USER' => 15,
    'ACTION_MODIFY_USER' => 16,
    'ACTION_DELETE_USER' => 17,
    'ACTION_CHANGE_PASSWORD' => 18,
    'ACTION_SET_REMINDER' => 19,
    'REMINDER_TYPE_EMAIL' => 1,
    'IS_MAIL_ON' => 0,
    'SERVER_TIMEZONE' => env('SERVER_TIMEZONE'),
    'LOCAL_TIMEZONE' => env('LOCAL_TIME_ZONE'),
    'APP_NAME' => 'LEAD CRM',
    'SP_EMAIL' => 'sp@leadmediaproduction.com'
];