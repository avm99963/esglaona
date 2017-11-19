<?php
require_once("core.php");
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Install</title>
    <?php include("includes/head.php"); ?>
  </head>
  <body>
    <h1>Esglaotournament install</h1>
    <?php
    if (!isset($_POST["username"])) {
      ?>
      <form method="post" action="install.php">
        <p>Enther the details for the first admin:</p>
        <p>Username: <input type="text" name="username"></p>
        <p>Password: <input type="password" name="password"></p>
        <p><input type="submit" value="Install"></p>
      </form>
      <?php
    } else {
      if (!isset($_POST["username"]) || !isset($_POST["password"]) || empty($_POST["username"]) || empty($_POST["password"]))

      $sql = array();

      $sql["users"] = "CREATE TABLE users
        (
          id INT(13) NOT NULL AUTO_INCREMENT,
      	  PRIMARY KEY(id),
      	  username VARCHAR(50) NOT NULL UNIQUE,
          password VARCHAR(255) NOT NULL,
          type INT(2)
        )";

      $sql["tournaments"] = "CREATE TABLE tournaments
	(
	  id INT(13) NOT NULL AUTO_INCREMENT,
	  PRIMARY KEY(id),
          codename VARCHAR(50),
          name VARCHAR(50),
      	  current_round INT(2),
          max_schedule_time INT(13)
        )";

      $sql["matches"] = "CREATE TABLE matches
        (
          id INT(13) NOT NULL AUTO_INCREMENT,
          PRIMARY KEY(id),
          challongeid INT(20),
          status INT(2),
          schedule INT(13),
          player1 INT(13),
          player2 INT(13),
          winner INT(2),
          mround INT(2),
          tournament INT(13)
        )";

      $sql["matrixs"] = "CREATE TABLE matrixs
        (
          id INT(13) NOT NULL AUTO_INCREMENT,
          PRIMARY KEY(id),
          internalmatch INT(13),
          matrix TEXT,
          winnermatrix TEXT,
          winner INT(13)
        )
      ";

      $sql["judges"] = "CREATE TABLE judges
        (
          id INT(13) NOT NULL AUTO_INCREMENT,
          PRIMARY KEY(id),
          internalmatch INT(13) NOT NULL,
          user INT(13) NOT NULL
        )
      ";

      foreach ($sql as $key => $query) {
        if (!mysqli_query($con, $query)) {
          die("<div class='alert danger'>Ha ocurrido un error inesperado al crear la tabla ".$key.": ".mysqli_error($con).".</div>");
        }
      }

      $username = htmlspecialchars(mysqli_real_escape_string($con, $_POST['username']));
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $sql6 = "INSERT INTO users (username, password, type) VALUES ('".$username."', '".$password."', 0)";
      if (!mysqli_query($con,$sql6)) {
        die("<div class='alert danger'>Ha ocurrido un error inesperado al crear el usuario administrador: ".mysqli_error($con).".</div>");
      }
      ?>
      <p><a href="index.php">Go log in</a><p>
      <?php
    }
    ?>
  </body>
</html>
