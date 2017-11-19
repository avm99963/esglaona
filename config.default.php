<?php
$conf = array();
$conf["db"] = array();
$conf["db"]["user"] = ""; // Enter the MySQL username
$conf["db"]["password"] = ""; // Enter the MySQL password
$conf["db"]["database"] = ""; // Enter the MySQL database name
$conf["db"]["host"] = ""; // Enter the MySQL host
$conf["path"] = ""; // Enter the absolute path to the website
$conf["pathForChallonge"] = ""; // See comment in the bottom
$conf["coolURLs"] = false; // Show cool URLs (f. ex. https://example.com/tournament/1 instead of https://example.com/tournament.php?id=1)
$conf["appName"] = "Esglaotournament"; // Enter the name of the website
$conf["challonge"] = array();
$conf["challonge"]["apiKey"] = ""; // Enter the API key for Challonge (get it at http://challonge.com/settings/developer)

/** If the main page is served at https://example.com/esglaotournament/index.php,
  * then set $conf["path"] = "/esglaotournament/";
  * and set $conf["pathForChallonge"] = "https://example.com/esglaotournament/";
  *
  * If it is served at https://subdomain.example.com/index.php, then set
  * $conf["path"] = "/"; and set
  * $conf["pathForChallonge"] = "https://subdomain.example.com/";
  */
