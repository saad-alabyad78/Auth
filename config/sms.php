<?php 

return [
    'gateway' => [
        'url' => env('SMS_GATWAY_URL' , 'https://www.traccar.org/sms/') , 
        'api_key' => env('SMS_GATWAY_APIKEY') ,
    ]
];
