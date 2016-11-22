<?php

$CALENDAR_ID = "sanruiz1003@gmail.com";
$redirect_uri ='http://localhost/index.php';
require_once 'vendor/autoload.php';

session_start();
// print_r($_SESSION);
if(isset($_GET["logout"])){
    session_destroy();
}

$client = new Google_Client();
// Get your credentials from the console
$client->setApplicationName('calendario-150306');
$client->setClientId('793723891981-3aa974f6r5g0ekpcp0gbnjjq8cinpa74.apps.googleusercontent.com');
$client->setClientSecret('ylSHTwmFduGH1iQiZxYMLdzn');
$client->setRedirectUri($redirect_uri);
$client->addScope('profile');
$client->addScope(Google_Service_Calendar::CALENDAR);
$client->getAccessToken();

print_r($client->getAccessToken());
$authUrl = $client->createAuthUrl();

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

if (!$client->getAccessToken() && !$_SESSION['access_token']) {
    $authUrl = $client->createAuthUrl();
    print "<a class='login' href='$authUrl'>Conectar</a>";
}
if (isset($_SESSION['access_token'])) {
    print "<a class='logout' href='".$_SERVER['PHP_SELF']."?logout=1'>Salir</a><br>";
    $client->setAccessToken($_SESSION['access_token']);
    $service = new Google_Service_Calendar($client);
    $results = $service->events->listEvents($CALENDAR_ID, array());
    if (count($results->getItems()) == 0) {
        print "<h3>No hay Eventos</h3>";
    } else {  print "<h3>Proximos Eventos</h3>";
        echo "<table border=1>";
        foreach ($results->getItems() as $event) {
            echo "<tr>";
            $start = $event->start->dateTime;
            if (empty($start)) {
                $start = $event->start->date;
            }
            echo "<td>".$event->getSummary()."</td>";
            echo "<td>".$start."</td>";
            echo "</tr>";
        }
        echo "<table>";
    }
}
?>

<form action="calendar.php">
    <input type="submit" value="Crear">
</form>
