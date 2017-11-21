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

if (!isset($_POST["winner"]) || ($_POST["winner"] != "0" && $_POST["winner"] != "1")) {
  echo "Sisplau, emplena qui és el guanyador.";
}

if (isset($_FILES["mt"]) && $_FILES["mt"]["error"] == 0) {
  $matriu = file_get_contents($_FILES["mt"]["tmp_name"]);
  $files = array_map(function ($el) { return trim(str_replace("\t", " ", $el)); }, explode("\n", $matriu));
  $files = array_slice($files, 2);
  $matriu = trim(implode("\n", $files));
} elseif (isset($_POST["matriu"]) && !empty($_POST["matriu"])) {
  $matriu = trim($_POST["matriu"]);
} else {
  $matriu = "";
}

$winner = (int)$_POST["winner"];

if (db::addMatrix($match["id"], $matriu, $winner)) {
  header("Location: judge.php?match=".$match["id"]."&msg=addedmatrix");
  exit();
} else {
  echo "Hi ha hagut un error guardant la matriu.";
}
