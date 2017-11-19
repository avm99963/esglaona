<?php
require_once("core.php");

security::checkType(0);

if (!isset($_POST["codename"]) || empty($_POST["codename"])) {
  header("Location: home.php?msg=empty"); 
  exit();
}

if (db::addTournament($_POST["codename"])) {
  header("Location: home.php?msg=tournamentadded");
  exit();
} else {
  echo "Hi ha hagut un error guardant el torneig.";
}

