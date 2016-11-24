<?php

class CalendarController{

    private $calendar = 'unbd5fgdiijq9qtf7iorrvkvos@group.calendar.google.com';
    private $redirectUri = 'http://localhost/index.php';
    private $authUrl = null;
    private $client = null;

    public function __construct() {
        session_start();

        if(isset($_GET["logout"])){
            session_destroy();
        }

        $client = new Google_Client(array('use_objects' => true));
        $client->setApplicationName('calendario-150306');
        $client->setClientId('793723891981-3aa974f6r5g0ekpcp0gbnjjq8cinpa74.apps.googleusercontent.com');
        $client->setClientSecret('ylSHTwmFduGH1iQiZxYMLdzn');
        $client->setRedirectUri($this->redirectUri);
        $client->addScope('profile');
        $client->addScope(Google_Service_Calendar :: CALENDAR);
        $client->getAccessToken();
        $this->authUrl = $client->createAuthUrl();
        $this->client = $client;
    }

    public function create($title, $description, $start, $end){
        $this->getClient()->setAccessToken($_SESSION['access_token']);
        $service = new Google_Service_Calendar($this->getClient());
        $event = new Google_Service_Calendar_Event(array(
            'summary' => $title,
            'description' => $description,
            'start' => array(
                'date' => $start,
            ),
            'end' => array(
                'date' => $end,
            )
        ));

        $results = $service->events->insert($this->getCalendar(), $event);
        return $results;
    }


    /**
     * @return Google_Client|null
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return null|string
     */
    public function getAuthUrl()
    {
        return $this->authUrl;
    }

    /**
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * @return string
     */
    public function getCalendar()
    {
        return $this->calendar;
    }
}