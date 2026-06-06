<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Invitation Expiry
    |--------------------------------------------------------------------------
    | Default number of days before an invitation expires.
    | Set to 0 to disable expiry entirely.
    */
    'invitation_expiry_days' => (int) env('INVITATION_EXPIRY_DAYS', 365),

    /*
    |--------------------------------------------------------------------------
    | QRIS Master String
    |--------------------------------------------------------------------------
    | The master QRIS string used to generate dynamic QRIS payments.
    */
    'qris_master_string' => env('QRIS_MASTER_STRING', '00020101021226610014COM.GO-JEK.WWW01189360091431720318940210G1720318940303UMI51440014ID.CO.QRIS.WWW0215ID10254220360590303UMI520456915303360540410005802ID5908Temanten6008PEMALANG61055235262070703A016304B3D8'),

];
