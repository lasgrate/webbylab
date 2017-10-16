<?php

// Include configs
include_once 'config.php';

// include autoloader
include_once 'autoloaders/autoloader.php';
include_once 'autoloaders/controllerAutoloader.php';

// Include helpers
include_once 'lib/helpers.php';

// Register pattern
$registry = new \App\Vendor\Registry();

// Request
$request = new \App\Vendor\Request();
$registry->set('request', $request);

// Response
$response = new \App\Vendor\Response();
$response->addHeader('Content-Type: text/html; charset=utf-8');
$registry->set('response', $response);

// DB
$db = new \App\Vendor\DB();
$registry->set('db', $db);

$action = new \App\Vendor\Action($registry);

$output = $action->execute();