<?php
require_once("core.php");

security::check();
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?=$conf["appName"]?></title>
    <?php include("includes/head.php"); ?>
  </head>
  <body>
    <?php visual::breadcumb([$conf["appName"]]); ?>
    <h1>Torneigs</h1>
    <?php
    if (isset($_GET["msg"])) {
      if ($_GET["msg"] == "empty") {
        echo "<p style='color: red;'>Sisplau, emplena tots els camps d'entrada.</p>";
      } elseif ($_GET["msg"] == "tournamentadded") {
        echo "<p style='color: green;'>Torneig afegit correctament.</p>";
      }
    }

    if (security::userType() == 0) {
      echo '<a href="addtournament.php">Afegeix un torneig</a> | <a href="users.php">Gestiona els usuaris</a>';
    }
    ?>
    <ul>
      <?php
      $tournaments = tournaments::getTournaments();

      if (count($tournaments)) {
        foreach ($tournaments as $t) {
          echo "<li><a href='tournament.php?id=".$t["id"]."'>".$t["name"]."</a></li>";
        }
      } else {
        echo "No hi ha cap torneig configurat encara.";
      }
      ?>
    </ul>
  </body>
</html>

