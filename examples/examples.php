<?php
// API Documentation: https://moosend.com/api
require __DIR__ . '/../src/Moosend.php';

$moosend = new Moosend('API_KEY');
$lists = $moosend->get('lists/1/2');
$subscribers = $moosend->get('subscribers/MAILING_LIST_ID/view', [ 'Email' => 'user@domain.tld' ]);
$res = $moosend->post('subscribers/MAILING_LIST_ID/update/SUBSCRIBER_ID', [ 
    'Email' => 'user@domain.tld', 
    'Name' => 'name' 
]);
$subscriber = $moosend->get('subscribers/MAILING_LIST_ID/find/SUBSCRIBER_ID');
$moosend->delete('lists/MAILING_LIST_ID/delete');
