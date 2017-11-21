<?php
require_once("core.php");

security::checkType(security::JUDGE);

$match = matches::getDBMatch($_POST["match"]);
if ($match === false || $match["status"] == 4) {
  header("Location: home.php");
  exit();
}

$jutges = matches::getDBJutges($match["id"]);

if (!in_array($_SESSION["id"], array_keys($jutges))) {
  header("Location: home.php");
  exit();
}

$tournament = tournaments::getTournament($match["tournament"]);
if ($tournament === false) {
  header("Location: home.php");
  exit();
}

$finish = matches::doFinish($match, $tournament["codename"]);
if ($finish == 0) {
  header("Location: judge.php?match=".$match["id"]);
  exit();
} elseif ($finish == -1) {
  echo "No s'ha pogut finalitzar la partida perquè hi ha un empat.";
} else {
  echo "Hi ha hagut un error (".$finish.") al finalitzar la partida.";
}
