<?php
require_once("core.php");

security::checkType(0);
?>
<!DOCTYPE html>
<html>
  <head>
    <title><?=$conf["appName"]?></title>
    <?php include("includes/head.php"); ?>
  </head>
  <body>
    <?php visual::breadcumb([["home.php", $conf["appName"]], "Afegir un torneig"]); ?>
    <h1>Afegir un torneig</h1>
    <form action="doaddtournament.php" method="POST">
      <p>Codi de Challonge: <input type="text" name="codename" required></p>
      <p><input type="submit" value="Afegeix"></p>
    </form>
</body>
</html>

