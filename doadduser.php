<?php
require_once("core.php");

security::checkType(0);

if (!isset($_POST["username"]) || empty($_POST["username"]) || !isset($_POST["password"]) || empty($_POST["password"]) || !isset($_POST["type"])) {
  header("Location: adduser.php?msg=empty");
  exit();
}

if (db::addUser($_POST["username"], $_POST["password"], $_POST["type"])) {
  header("Location: users.php?msg=useradded");
  exit();
} else {
  echo "Hi ha hagut un error guardant l'usuari.";
}
