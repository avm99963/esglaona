<?php
require_once("core.php");

security::checkType(0);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Afegeix un usuari – <?=$conf["appName"]?></title>
    <?php include("includes/head.php"); ?>
  </head>
  <body>
    <?php visual::breadcumb([["home.php", $conf["appName"]], ["users.php", "Usuaris"], "Afegir un usuari"]); ?>
    <h1>Afegir un usuari</h1>
    <form action="doadduser.php" method="POST">
      <p>Usuari: <input type="text" name="username" required></p>
      <p>Contrasenya: <input type="password" name="password" required></p>
      <p>Tipus: <select name="type"><?php foreach (security::$types as $i => $type) { echo '<option value="'.$i.'">'.$type.'</option>'; } ?></select></p>
      <p><input type="submit" value="Afegeix"></p>
    </form>
  </body>
</html>

