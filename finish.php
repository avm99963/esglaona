<?php
require_once("core.php");

security::checkType(security::JUDGE);

$match = matches::getDBMatch($_GET["match"]);
if ($match === false) {
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

$participants = api::getArrayParticipants($tournament["codename"]);
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?=$participants[$match["player1"]]." vs. ".$participants[$match["player2"]]." – ".$tournament["name"]?></title>
    <?php include("includes/head.php"); ?>
  </head>
  <body>
    <?php visual::breadcumb([["home.php", $conf["appName"]], ["tournament.php?id=".$tournament["id"], $tournament["name"]], ["judge.php?match=".$match["id"], "Jutja"], "Finalitza la partida"]); ?>
    <h1>Finalitza la partida <?=$participants[$match["player1"]]." vs. ".$participants[$match["player2"]]?> – <?=$tournament["name"]?></h1>
    <p>Si ja s'ha acabat la partida i s'han pujat els resultats de tots els esglaonaments al web (en particular 1 a les primeres rondes i 3 a les últimes), pots clicar el següent botó per indicar que ja s'ha jugat i pujar automàticament els resultats al Challonge.</p>
    <form action="dofinish.php" method="POST">
      <input type="hidden" name="match" value=<?=$match["id"]?>>
      <input type="submit" value="Finalitza la partida">
    </form>
  </body>
</html>
