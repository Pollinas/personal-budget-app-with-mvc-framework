<?php

/**
 * Front controller
 *
 * PHP version 7.4
 */

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Sessions
 */
session_start();

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('signup', ['controller' => 'Signup', 'action' => 'new']);
$router->add('login', ['controller' => 'Login', 'action' => 'new']);
$router->add('logout', ['controller' => 'Login', 'action' => 'destroy']);
$router->add('password/reset/{token:[\da-f]+}', ['controller' => 'Password', 'action' => 'reset']);
$router->add('signup/activate/{token:[\da-f]+}', ['controller' => 'Signup', 'action' => 'activate']);

$router->add('settings' , ['controller' => 'Settings', 'action' => 'index']);
$router->add('balance' , ['controller' => 'Displaybalance', 'action' => 'index']);
$router->add('expense' , ['controller' => 'Addexpense', 'action' => 'new']);
$router->add('income' , ['controller' => 'Addincome', 'action' => 'new']);

$router->add('api/limit/{category:[A-Za-ząĄćĆęĘłŁńŃóÓśŚżŻźŹ\w]+}', ['controller' => 'Addexpense', 'action' => 'limit']);

$router->add('api/expenses/{category:[A-Za-ząĄćĆęĘłŁńŃóÓśŚżŻźŹ\w]+}/{date:[\d+\-\d+\-\d+]+}', ['controller' => 'Addexpense', 'action' => 'expenses']);



$router->add('{controller}/{action}');

    
$router->dispatch($_SERVER['QUERY_STRING']);
