<?php

include_once 'google_service.class.php';



// https://developers.google.com/api-client-library/php/guide/batch
// http://stackoverflow.com/questions/17840333/google-calendar-api-batch-request-php
// http://stackoverflow.com/questions/20247741/batch-request-google-calendar-php-api?rq=1

// GoogleService is just a class to abstract same complexity
// you just need to know, that it provide the client and the service
$resource = new GoogleService();

$resource->get_client()->setUseBatch(true);
$batch = new Google_Http_Batch($resource->get_client());

$event = new Google_Service_Calendar_Event();
$event->setSummary("Teste - 1");
$start = new Google_Service_Calendar_EventDateTime();
$start->setDateTime(GoogleService::date3339(time()));
$start->setTimeZone("America/Sao_Paulo");
$event->setStart($start);
$end = new Google_Service_Calendar_EventDateTime();
$end->setDateTime(GoogleService::date3339( time() + 3600 ));
$end->setTimeZone("America/Sao_Paulo");
$event->setEnd($end);

// The add method, will intercept the request and add it on a request list
// So inside the add method, just do a regular google Call
$batch->add( $resource->get_service()->events->insert('primary', $event), "1");

$event = new Google_Service_Calendar_Event();
$event->setSummary("Teste - 2");
$start = new Google_Service_Calendar_EventDateTime();
$start->setDateTime(GoogleService::date3339(time()));
$start->setTimeZone("America/Sao_Paulo");
$event->setStart($start);
$end = new Google_Service_Calendar_EventDateTime();
$end->setDateTime(GoogleService::date3339( time() + 3600 ));
$end->setTimeZone("America/Sao_Paulo");
$event->setEnd($end);

// The add method, will intercept the request and add it on a request list
// So inside the add method, just do a regular google Call
$batch->add( $resource->get_service()->events->insert('primary', $event), "2");

$results = $batch->execute();

//If you want to use batch again, first clear the last request
$batch = new Google_Http_Batch($resource->get_client());


$resource->get_client()->setUseBatch(false);

echo '<pre>';

foreach ($results as $result){
    var_dump($result);
    echo '<hr />';
}
