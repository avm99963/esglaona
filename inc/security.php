<?php
class security {
  const ADMIN = 0;
  const JUDGE = 1;
  const COORDINATOR = 2;

  public static $types = [
    0 => "Admin",
    1 => "Jutge",
    2 => "Coordinador"
  ];

  public static function isSignedIn() {
    global $_SESSION;

    return isset($_SESSION["id"]);
  }

  public static function check() {
    if (!self::isSignedIn()) {
      header("Location: index.php");
      exit();
    }
  }

  public static function userType() {
    global $_SESSION, $con;

    $query = mysqli_query($con, "SELECT type FROM users WHERE id = ".(int)$_SESSION["id"]);

    if (!mysqli_num_rows($query)) {
      return 10;
    }

    $row = mysqli_fetch_assoc($query);

    return $row["type"];
  }

  public static function isAllowed($type) {
    if (!self::isSignedIn()) {
      return false;
    }

    if ($type < self::userType()) {
      return false;
    }
 
    return true;
  }

  public static function checkType($type) {
    if (!self::isAllowed($type)) {
      header("Location: index.php");
      exit();
    }
  }
}
