<?php
require_once("core.php");

security::check();

if (!isset($_POST["match"]) || empty($_POST["match"]) || !isset($_POST["datetime"]) || empty($_POST["datetime"])) {
  header("Location: home.php");
  exit();
}

$match = matches::getDBMatch($_POST["match"]);
if ($match === false) {
  header("Location: home.php");
  exit();
}

if (db::modifyMatch($_POST["match"], $_POST["datetime"])) {
  header("Location: tournament.php?id=".$match["tournament"]);
  exit();
} else {
  echo "Hi ha hagut un error modificant l'hora.";
}
