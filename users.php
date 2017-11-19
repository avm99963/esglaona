<?php
require_once("core.php");

security::checkType(0);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Usuaris – <?=$conf["appName"]?></title>
    <?php include("includes/head.php"); ?>
  </head>
  <body>
    <?php visual::breadcumb([["home.php", $conf["appName"]], "Usuaris"]); ?>
    <h1>Usuaris</h1>
    <?php
    visual::msg([["useradded", "S'ha afegit l'usuari correctament.", "success"]]);
    ?>
    <p><a href="adduser.php">Afegeix un usuari</a></p>
    <table class="wikitable">
      <tr><th>ID</th><th>Usuari</th><th>Tipus</th></tr>
      <?php
      $usuaris = db::getUsers();
      foreach ($usuaris as $usuari) {
        if ($usuari["type"] <= 2) {
          $tipus = security::$types[$usuari["type"]];
        } else {
          $tipus = $usauri["type"];
        }
        echo "<tr><td>".$usuari["id"]."</td><td>".$usuari["username"]."</td><td>".$tipus."</td></tr>";
      }
      ?>
    </table>
  </body>
</html>

