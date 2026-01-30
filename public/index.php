<?php

session_start(); 

define('ROOT', dirname(__DIR__));

require_once ROOT . '/core/config.php';
require_once ROOT . '/core/App.php';
require_once ROOT . '/core/Controller.php';
require_once ROOT . '/core/Database.php';

new App;
