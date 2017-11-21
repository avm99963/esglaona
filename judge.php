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

$matrius = matches::getDBMatrixs($match["id"]);
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?=$participants[$match["player1"]]." vs. ".$participants[$match["player2"]]." – ".$tournament["name"]?></title>
    <?php include("includes/head.php"); ?>
  </head>
  <body>
    <?php visual::breadcumb([["home.php", $conf["appName"]], ["tournament.php?id=".$tournament["id"], $tournament["name"]], "Jutja"]); ?>
    <h1>Jutja la partida <?=$participants[$match["player1"]]." vs. ".$participants[$match["player2"]]?> – <?=$tournament["name"]?></h1>
    <?php
    if (count($matrius) && $match["status"] != 4) {
      echo "<a href='finish.php?match=".$match["id"]."'>Finalitza la partida i puja els resultats a Challonge</a>";
    }

    if ($match["status"] == 4) {
      echo "<p>Aquesta partida ja s'ha jutjat i ha finalitzat.</p>";
    }
    ?>
    <h3>Matrius</h3>
    <?=visual::msg([["addedmatrix", "S'ha afegit la matriu correctament.", "success"]])?>
    <?php
    if (!count($matrius)) {
      echo "<p>Encara no s'ha esglaonat cap matriu.</p>";
    } else {
      foreach ($matrius as $matriu) {
        echo "<pre>".$matriu["matrix"]."</pre><p><b>Guanyador:</b> ".$participants[$match["player".$matriu["winner"]]]."</p>";
      }
    }

    if ($match["status"] != 4) {
      ?>
      <hr>
      <h3>Afegeix una matriu esglaonada</h3>
      <p>Si estàs jutjant aquesta partida, pots afegir la matriu original que s'ha hagut d'esglaonar (recomanat però és opcional) i qui ha guanyat:</p>
      <form action="doaddmatrix.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="match" value="<?=$match["id"]?>">
        <p>Fitxer de la matriu: <input type="file" name="mt" accept=".mt"></p>
        <p>En comptes de pujar un fitxer també pots introduir la matriu manualment (introdueix cada fila en una línia amb els elements separats amb espais):<br><textarea name="matriu" style="width: 150px; height: 150px; font-size: 13px; font-family: monospace;" placeholder="1 -1/12 13&#10;0 -2 0&#10;0 0 1/13"></textarea></p>
        <div>
          Guanyador:<br>
          <input type="radio" name="winner" value="1" id="player1" required> <label for="player1"><?=$participants[$match["player1"]]?></label><br>
          <input type="radio" name="winner" value="2" id="player2" required> <label for="player2"><?=$participants[$match["player2"]]?></label>
        </div>
        <p><input type="submit" value="Afegeix matriu"></p>
      </form>
      <?php
    }
    ?>
  </body>
</html>
