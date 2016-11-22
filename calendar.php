<?php

$CALENDAR_ID = "sanruiz1003@gmail.com";
$redirect_uri ='http://localhost/index.php';
require_once 'vendor/autoload.php';


$client = new Google_Client(array('use_objects' => true));
// Get your credentials from the console
$client->setApplicationName('calendario-150306');

$client->setClientId('793723891981-3aa974f6r5g0ekpcp0gbnjjq8cinpa74.apps.googleusercontent.com');
$client->setClientSecret('ylSHTwmFduGH1iQiZxYMLdzn');
$client->setRedirectUri($redirect_uri);
//$client->addScope('profile');
$client->addScope(Google_Service_Calendar :: CALENDAR);
$client->getAccessToken();

print_r($client->getAccessToken());
$authUrl = $client->createAuthUrl();

$service = new Google_Service_Calendar($client);

$event = new Google_Service_Calendar_Event(array(
    'summary' => 'Google I/O 2015',
    'location' => '800 Howard St., San Francisco, CA 94103',
    'description' => 'A chance to hear more about Google\'s developer products.',
    'start' => array(
        'dateTime' => '2015-05-28T09:00:00-07:00',
        'timeZone' => 'America/Los_Angeles',
    ),
    'end' => array(
        'dateTime' => '2015-05-28T17:00:00-07:00',
        'timeZone' => 'America/Los_Angeles',
    ),
    'recurrence' => array(
        'RRULE:FREQ=DAILY;COUNT=2'
    ),
    'attendees' => array(
        array('email' => 'lpage@example.com'),
        array('email' => 'sbrin@example.com'),
    ), 'reminders' => array(
        'useDefault' => FALSE,
        'overrides' => array(
            array('method' => 'email', 'minutes' => 24 * 60),
            array('method' => 'popup', 'minutes' => 10),
        ),
    ),
));

/*$event->setSummary('Event nuevo');
$event->setLocation('en un sitio');

$start = new Google_Service_Calendar_EventDateTime();
$start->setDateTime('2014-10-02T19:00:00.000+01:00');
$start->setTimeZone('Europe/Madrid');
$event->setStart($start);

$end = new Google_Service_Calendar_EventDateTime();
$end->setDateTime('2014-10-02T19:25:00.000+01:00');
$end->setTimeZone('Europe/Madrid');
$event->setEnd($end);
*/

$new_event = null;
$new_event_id = "";

$new_event = $service->events->insert($CALENDAR_ID, $event);


if($new_event!=null){

    $new_event_id= $new_event->getId();
    $event = $service->events->get($CALENDAR_ID, $new_event_id);

    if ($event != null) {
        echo "<br/>Inserted:";
        echo "<br/>EventID=".$event->getId();
        echo "<br/>Summary=".$event->getSummary();
        echo "<br/>Status=".$event->getStatus();
    }
    else{
        echo "No se ha podido obtener la información del evento";
    }
}else{
    echo "No se ha podido insertar el evento";
}

//http://anexsoft.com/p/61/realizando-un-crud-con-el-patron-mvc-en-php

// http://blogs.ua.es/labseps/2014/10/17/insertar-un-evento-en-un-calendario-publico-de-google-con-php-y-la-api-v3/
// https://developers.google.com/google-apps/calendar/v3/reference/events/insert
//http://stackoverflow.com/questions/26064095/inserting-google-calendar-entries-with-service-account
//http://evilnapsis.com/2016/10/08/api-conectar-y-listar-eventos-de-google-calendar-con-php/

//https://reviblog.net/2014/05/06/insertar-un-boton-en-tu-web-para-anadir-un-evento-a-google-calendar/
?>


