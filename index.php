<?php

session_start();

define ('ROOT', dirname(__FILE__));

require_once(ROOT. '/components/Autoload.php');
require_once(ROOT. '/components/phpQuery.php');
require_once(ROOT. '/helpers.php');

$router = new Router();
$router->run();