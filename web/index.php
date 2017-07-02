<?php

//Entry point of Api Server Application

require __DIR__. '/../src/Utils/autoloader.php';

$frontController = new Utils\Classes\FrontController();
$frontController->run();