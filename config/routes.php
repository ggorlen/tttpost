<?php

// List of valid routes 
$routes = [
  'admin'      => 'AdminController',
  'deregister' => 'DeregisterController',
  'home'       => 'HomeController',
  'login'      => 'LoginController',
  'logout'     => 'LogoutController',
  'move'       => 'MoveController',
  'seeks'      => 'SeeksController',
  'newseek'    => 'NewSeekController',
  'removeseek' => 'RemoveSeekController',
  'joinseek'   => 'JoinSeekController',
  'profile'    => 'ProfileController',
  'register'   => 'RegisterController',
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
