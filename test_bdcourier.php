<?php
$ch = curl_init('https://bdcourier.com/api/pro/courier-check');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'api_key' => '9WnAP2ZQSycASQG5n1ymO6ADwca2tRAjdwAjaZc1qIClGRjepiRWZPZUy642',
    'phone' => '01711223344'
]));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
$resp = curl_exec($ch);
echo "Response:\n";
echo $resp;
