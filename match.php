<?php
require_once("core.php");

$match = matches::getDBMatch($_GET["id"], false);
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

$jutges = matches::getDBJutges($match["id"]);
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?=$participants[$match["player1"]]." vs. ".$participants[$match["player2"]]." – ".$tournament["name"]?></title>
    <?php include("includes/head.php"); ?>
  </head>
  <body>
    <h1><?=$participants[$match["player1"]]." vs. ".$participants[$match["player2"]]?> – <?=$tournament["name"]?></h1>
    <h3>Informació sobre la partida</h3>
    <p><b>Data:</b> <?=date("D d/m/Y H:i", $match["schedule"])?></p>
    <?php
    if (!empty($match["winner"])) {
      echo "<p><b>Guanyador de la partida:</b> ".$participants[$match["player".$match["winner"]]]."</p>";
    }
    if (!count($jutges)) {
      echo "<p><b>Jutges:</b> de moment no hi ha cap jutge inscrit</p>";
    } else {
      ?>
      <p><b>Jutges:</b></p>
      <ul>
        <?php
        foreach ($jutges as $jutge) {
          echo "<li>".$jutge."</li>";
        }
        ?>
      </ul>
      <?php
    }

    $matrius = matches::getDBMatrixs($match["id"]);

    if (count($matrius)) {
      ?>
      <h3>Matrius</h3>
      <?php
      foreach ($matrius as $matriu) {
        echo "<pre>".$matriu["matrix"]."</pre><p><b>Guanyador:</b> ".$participants[$match["player".$matriu["winner"]]]."</p>";
      }
      ?>
      <?php
    }
    ?>
  </body>
</html>
