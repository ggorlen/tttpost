<?php

// Import global app config
require 'config/config.php';
require DB_CREDENTIALS;

// Import MVC classes 
$dirs = [
  LIB . '/*.php',
  MODELS . '/*.php',
  MODELS . '/games/*.php',
  MODELS . '/games/ttt/*.php',
  CONTROLLERS . '/*.php',
  CONTROLLERS . '/helpers/*.php'
];

// TODO glob recursively
foreach ($dirs as $dir) {
    foreach (glob($dir) as $file) { 
        require $file; 
    }
}

// Route request to the correct controller
require 'config/routes.php';

?>
