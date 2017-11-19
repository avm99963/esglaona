<?php
require_once("core.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?=$conf["appName"]?></title>
    <?php include("includes/head.php"); ?>
  </head>
  <body>
    <?php
    if (!isset($_POST["tournament"])) {
      header("Location: ".visual::url("home.php", "home"));
      exit();
    }

    if (!isset($_POST["match"]) || !isset($_POST["datetime"]) || !isset($_POST["iagree"])) {
      header("Location: ".visual::url("schedule_participant.php?id=".(int)$_POST["tournament"], "schedule/".(int)$_POST["tournament"]));
      exit();
    }

    $tournament = tournaments::getTournament($_POST["tournament"]);
    ?>
    <h1><?=$tournament["name"]?></h1>
    <?php
    $match = api::getMatch($tournament["codename"], $_POST["match"]);

    if ($match === false) {
      exit();
    }

    $internalmatch = matches::getDBMatch($_POST["match"], false);

    if ($internalmatch !== false) {
      echo "Aquesta partida ja s'ha programat. Si no ho heu fet vosaltres, parleu amb un dels jutges per tal de concretar el dia i l'hora manualment.";
      exit();
    }

    // @TODO: Implement if the time is less than the max allowed

    if (db::addMatch($match, $tournament["id"], $_POST["datetime"])) {
      ?>
      <p>La partida ha estat programada correctament. Ara haureu d'esperar que almenys 2 jutges estiguin disponibles per poder jutjar la partida a l'hora que demanat. Podeu consultar la pàgina del Challonge per veure quins jutges tindreu a la partida.</p>
      <p>Heu demanat la següent data: <?=date("D d/m/Y H:i", strtotime($_POST["datetime"]))?> Us recomanem que feu una captura de pantalla d'aquesta pàgina per si voleu veure quina hora vàreu demanar en el futur.</p>
      <?php
    }
    ?>
  </body>
</html>
