<?php
require_once("core.php");

security::check();

$match = matches::getDBMatch($_GET["id"]);
if ($match === false) {
  header("Location: home.php");
  exit();
}

$tournament = tournaments::getTournament($match["tournament"]);
if ($tournament === false) {
  header("Location: home.php");
  exit();
}

$participants = api::getArrayParticipants($tournament["codename"]);
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?=$participants[$match["player1"]]." vs. ".$participants[$match["player2"]]." – ".$conf["appName"]?></title>
    <?php include("includes/head.php"); ?>
  </head>
  <body>
    <?php visual::breadcumb([["home.php", $conf["appName"]], ["tournament.php?id=".$tournament["id"], $tournament["name"]], "Canvia la data"]); ?>
    <h1>Canvia la data de la partida <?=$participants[$match["player1"]]." vs. ".$participants[$match["player2"]]?></h1>
    <?=visual::msg([["empty", "Sisplau, emplena tots els camps d'entrada.", "error"]])?>
    <form action="domodifymatch.php" method="POST">
      <input type="hidden" name="match" value="<?=$match["id"]?>">
      <p>Hora: <input type="datetime-local" name="datetime" value="<?=date("Y-m-d\TH:i", $match["schedule"])?>"></p>
      <p><input type="submit" value="Canvia"></p>
    </form>
    </ul>
  </body>
</html>
