<?php
require_once("core.php");

security::checkType(0);

if (!isset($_POST["tournament"]) || !isset($_POST["current_round"])) {
  header("Location: home.php");
  exit();
}

$tournament = tournaments::getTournament($_POST["tournament"]);
if ($tournament === false) {
  header("Location: home.php");
  exit();
}

if (db::changeCurrentRound($_POST["tournament"], $_POST["current_round"])) {
  header("Location: tournament.php?id=".$_POST["tournament"]."&msg=roundchanged");
  exit();
} else {
  echo "Hi ha hagut un problema canviant de ronda.";
}
