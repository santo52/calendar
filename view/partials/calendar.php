<?php

$calendar = new CalendarController(true);
$client = $calendar->getClient();

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['access_token'] = $client->getAccessToken();
    header('Location: ' . filter_var($calendar->getRedirectUri(), FILTER_SANITIZE_URL));
}
if (!$client->getAccessToken() && !isset($_SESSION['access_token'])) {
    $authUrl = $client->createAuthUrl();
    echo "<div class='linkButton'><a class='login' href='$authUrl'>Conectar con Google Calendar</a></div>";
}
if (isset($_SESSION['access_token'])) {
    echo "<div class='linkButton'><a class='logout' href='".$_SERVER['PHP_SELF']."?logout=1'>Salir de Google Calendar</a></div>";
    echo "<div class='linkButton'><a href='#' id='calendarOpen'>Insertar un evento</a></div>";
}

echo "<div style='margin: 20px auto; width: 500px;'>
            <iframe src='https://calendar.google.com/calendar/embed?src=unbd5fgdiijq9qtf7iorrvkvos%40group.calendar.google.com&ctz=America/Bogota' style='border: 0' width='100%' height='300' frameborder='0' scrolling='no'></iframe>
         </div>";