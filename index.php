<?php
require_once("core.php");

if (security::isSignedIn()) {
  header("Location: home.php");
  exit();
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Log in</title>
    <?php include("includes/head.php"); ?>
  </head>
  <body>
    <h1><?php echo $conf["appName"]; ?></h1>
    <?php
    if (isset($_GET["msg"])) {
      if ($_GET["msg"] == "empty") {
        echo "<p style='color: red;'>Sisplau, omple tot el formulari.</p>";
      } elseif ($_GET["msg"] == "wrong") {
        echo "<p style='color: red;'>L'usuari i la contrasenya no són correctes.</p>";
      } elseif ($_GET["msg"] == "logout") {
        echo "<p style='color: green;'>Has tancat la sessió satisfactòriament!</p>";
      }
    }
    ?>
    <form action="signin.php" method="POST">
      <p>Usuari: <input type="text" name="username"></p>
      <p>Contrasenya: <input type="password" name="password"></p>
      <p><input type="submit" value="Inicia sessió"></p>
    </form>
  </body>
</html>
