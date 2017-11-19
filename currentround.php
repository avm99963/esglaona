<?php
require_once("core.php");

security::checkType(0);

$tournament = tournaments::getTournament($_GET["id"]);
if ($tournament === false) {
  header("Location: home.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?=$tournament["name"]." – ".$conf["appName"]?></title>
    <?php include("includes/head.php"); ?>
  </head>
  <body>
    <?php visual::breadcumb([["home.php", $conf["appName"]], ["tournament.php?id=".$tournament["id"], $tournament["name"]], $tournament["name"]]); ?>
    <h1>Canvia la ronda actual</h1>
    <form action="<?=visual::url("docurrentround.php")?>" method="POST">
      <input type="hidden" name="tournament" value="<?=$tournament["id"]?>">
      <p>Ronda actual: <input type="number" name="current_round" value="<?=$tournament["current_round"]?>"></p>
      <p><input type="submit" value="Canvia-la"></p>
    </form>
    </ul>
  </body>
</html>
