<?php

// List of valid routes 
$routes = [
  'home'      => 'HomeController',
  'login'     => 'LoginController',
  'logout'    => 'LogoutController',
  'new'       => 'NewGameController',
  'profile'   => 'ProfileController',
  'register'  => 'RegisterController',
];

const DEFAULT_ROUTE = 'home';

// Retrieve the page from the GET request 
if (count($_GET) && isset($_GET['page'])) {
  $page = $_GET['page'];
}

// Determine if this is a valid route or use default
if (!isset($page) || !array_key_exists($page, $routes)) {
  $page = DEFAULT_ROUTE;
}

// Make the selected controller and invoke it using any posted data
$controller = new $routes[$page]();
echo $controller->call($_POST);

?>
