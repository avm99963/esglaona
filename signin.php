<?php
require_once("core.php");

if (!isset($_POST["username"]) || !isset($_POST["password"]) || empty($_POST["username"]) || empty($_POST["password"])) {
  header("Location: index.php?msg=empty");
  exit();
}

$query = mysqli_query($con, "SELECT * FROM users WHERE username = '".mysqli_real_escape_string($con, $_POST["username"])."'");

if (mysqli_num_rows($query)) {
  $row = mysqli_fetch_assoc($query);

  if (password_verify($_POST["password"], $row["password"])) {
    $_SESSION["id"] = $row["id"];
    header("Location: home.php");
    exit();
  } else {
    header("Location: index.php?msg=wrong");
    exit();
  }
} else {
  header("Location: index.php?msg=wrong");
  exit();
}
