<?php

return [
    'driver' => env('FCM_PROTOCOL', 'http'),
    'log_enabled' => false,

    'http' => [
        'server_key' => env('FCM_SERVER_KEY', 'AAAAvx9fwmA:APA91bHRkVF1DmexfQvmm9BnQ2R-7oJD-qjGFiSVZ-hwy-HdsusrUdRaYsiBCA8cOSZW-DgctJ8et6iFCN0xSFfBmPR4VrsdPsctkrguqC1Kz9pjfgIKuz8zWldbG1bLA_BKAyI2yyGM'),
        'sender_id' => env('FCM_SENDER_ID', '820865122912'),
        'server_send_url' => 'https://fcm.googleapis.com/fcm/send',
        'server_group_url' => 'https://android.googleapis.com/gcm/notification',
        'timeout' => 30.0, // in second
    ],
];
