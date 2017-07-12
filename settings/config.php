<?php

  //Database configuration
  define("DB_HOST", "localhost");
  define("DB_NAME", "mvcadrian");
  define("DB_USER", "root");
  define("DB_PASS", "");

  //Global variables
  define("BASE_URL", "http://mvc.adrian/");
  define("UPLOAD_URL", BASE_URL . "uploads");
  define("MODE", 'devON');


  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  session_start();

?>
