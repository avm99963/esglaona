<?php
require_once("core.php");

security::checkType(SECURITY::JUDGE);

if (!isset($_GET["match"])) {
  header("Location: home.php");
  exit();
}

$match = matches::getDBMatch($_GET["match"]);

if ($match === false) {
  exit();
}

if (db::applyForMatch($_GET["match"], (isset($_GET["doit"]) && $_GET["doit"] == 0) ? false : true)) {
  header("Location: tournament.php?id=".$match["tournament"]);
  exit();
} else {
  echo "Hi ha hagut un error inesperat.";
}
