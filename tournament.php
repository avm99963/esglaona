<?php
require_once("core.php");

security::check();

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
    <?php visual::breadcumb([["home.php", $conf["appName"]], $tournament["name"]]); ?>
    <h1><?=$tournament["name"]?></h1>
    <?=visual::msg([["empty", "Sisplau, emplena tots els camps d'entrada.", "error"], ["roundchanged", "S'ha canviat la ronda actual correctament.", "success"]])?>
    <?php
    if (security::userType() < security::COORDINATOR) {
      echo '<a href="'.visual::url("schedule/".$tournament["id"]).'">Programa una partida</a>';
    }

    if (security::userType() == security::ADMIN) {
      echo ' | <a href="currentround.php?id='.$tournament["id"].'">Canvia la ronda actual</a>';
    }

    $participants = api::getArrayParticipants($tournament["codename"]);

    $pmatches = matches::getPartialDBMatches($tournament["id"]);

    foreach ($pmatches as $i => &$matches) {
      echo "<h3>".($i == 0 ? "Partits pendents" : "Partits finalitzats")."</h3>";
      if (count($matches)) {
        ?>
        <div style="overflow-x: scroll; -webkit-overflow-scrolling: touch; white-space: nowrap;">
          <table class="wikitable" style="margin: 0;">
            <tr><th>Ronda</th><th>Jugador 1</th><th>Jugador 2</th><th>Data</th><th>Jutges</th><th></th></tr>
            <?php
            foreach ($matches as $m) {
              $jutges = matches::getDBJutges($m["id"]);
              ?>
                <tr>
                  <th><?=($m["mround"] - 1)?></th>
                  <td><?=$participants[$m["player1"]]?></td>
                  <td><?=$participants[$m["player2"]]?></td>
                  <td><?=date("D d/m/Y H:i", $m["schedule"])?></td>
                  <td><?=implode(", ", $jutges)?></td>
                  <td><a href='modifymatch.php?id=<?=$m["id"]?>'>Canvia la data</a><?php if (security::userType() <= security::JUDGE) { ?> | <?=(in_array($_SESSION["id"], array_keys($jutges)) ?  "<a href='apply.php?doit=0&match=".$m["id"]."'>Vull deixar de ser jutge</a> | <a href='judge.php?match=".$m["id"]."'>Jutja</a>" : "<a href='apply.php?doit=1&match=".$m["id"]."'>Vull ser jutge</a>")?><?php } ?></td>
                </tr>
              <?php
            }
            ?>
          </table>
        </div>
        <?php
      } else {
        echo "<p>No hi ha cap partida programada encara.</p>";
      }
    }
    ?>
    <h3>Diagrama de Challonge</h3>
    <div style="overflow-x: auto; -webkit-overflow-scrolling: touch; max-width: 100%;">
      <img src="<?=visual::url("challongesvg.php?codename=".$tournament["codename"])?>">
    </div>
  </body>
</html>
