<?php
class matches {
  const PENDING = 0;
  const OPEN = 1;
  const SCHEDULED = 2;
  const SCHEDULED_WITH_JUDGES = 3;
  const IN_PROGRESS = 4;
  const FINISHED = 5;

  public static function getDBMatches($id) {
    global $con;

    $query = mysqli_query($con, "SELECT * FROM matches WHERE tournament = ".(int)$id." ORDER BY mround ASC");

    $r = [];

    while ($row = mysqli_fetch_assoc($query)) {
      $r[] = $row;
    }

    return $r;
  }

  public static function getDBMatch($id, $internal=true) {
    global $con;

    $query = mysqli_query($con, "SELECT * FROM matches WHERE ".($internal ? "id" : "challongeid")." = ".(int)$id);

    if (mysqli_num_rows($query)) {
      return mysqli_fetch_assoc($query);
    }

    return false;
  }

  public static function getDBJutges($match) {
    global $con;

    $query = mysqli_query($con, "SELECT users.id, users.username FROM users, judges WHERE judges.user = users.id AND judges.internalmatch = ".(int)$match) or die(mysqli_error($con));

    $jutges = [];

    while ($row = mysqli_fetch_assoc($query)) {
      $jutges[$row["id"]] = $row["username"];
    }

    return $jutges;
  }
}
