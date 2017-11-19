<?php
// The simple core

// Getting configuration
require_once("config.php");

// Setting timezone accordingly
date_default_timezone_set("Europe/Madrid");

// Database settings
$con = @mysqli_connect($conf["db"]["server"], $conf["db"]["user"], $conf["db"]["password"], $conf["db"]["database"]) or die("There was an error connecting to the database.");
mysqli_set_charset($con, "utf8mb4");

// Session settings
session_set_cookie_params(0, $conf["path"]);
session_start();

// Classes autoload
spl_autoload_register(function($className) {
  include_once(__DIR__."/inc/".$className.".php");
});
