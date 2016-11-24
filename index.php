<?php

require_once 'vendor/autoload.php';
require_once 'controller/UserController.php';
require_once 'controller/CalendarController.php';

$controller = new UserController();
$controller->handleRequest();
?>
