<?php

$router = $di->getRouter();

$router->add("/", "App\\Controllers\\Index::index", null, \Phalcon\Mvc\Router::POSITION_FIRST);

// Define your routes here
$router->add(
    "/:controller/:action/:params",
    array(
        "namespace"  => "App\\Controllers",
        "controller" => 1,
        "action"     => 2,
        "params"     => 3,
    ),
    ['GET', "POST", "PUT", "DELETE"]
);
