<?php
require_once("core.php");

$tournament = tournaments::getTournament($_GET["id"]);

if ($tournament === false) {
  header("Location: ".$conf["path"]."home");
  exit();
}

$matches = api::getMatches($tournament["codename"]);

$participants = api::getArrayParticipants($tournament["codename"]);

$options = "<option value=''></option>";

foreach ($matches as $match) {
  if ($match["match"]["round"] <= $tournament["current_round"] && $match["match"]["state"] != "pending" && $match["match"]["state"] != "complete" && !empty($match["match"]["player1_id"]) && !empty($match["match"]["player2_id"])) {
    $options .= "<option value='".$match["match"]["id"]."'>".$participants[$match["match"]["player1_id"]]." vs. ".$participants[$match["match"]["player2_id"]]." (ronda ".($match["match"]["round"] - 1).")</option>";
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?=$conf["appName"]?></title>
     <?php include("includes/head.php"); ?>
  </head>
  <body>
    <h1><?=$tournament["name"]?></h1>
    <p>Hola! Si sou dos participants i ja us heu posat d'acord respecte a quina hora voleu jugar la partida, ompliu el següent formulari:</p>
    <form action="<?=(visual::url("doschedule_participant.php"));?>" method="POST" novalidate>
      <input type="hidden" name="tournament" value="<?=(int)$_GET["id"]?>">
      <p>Partida: <select name="match" required><?=$options?></select></p>
      <p>Hora: <input type="datetime-local" name="datetime"></p>
      <p><input type="checkbox" name="iagree" required> Pel bé del campionat, ens comprometem a estar disponibles per jugar la partida a l'hora demanada.</p>
      <p><input type="submit" value="Programa la partida"></p>
    </form>
  </body>
</html>
