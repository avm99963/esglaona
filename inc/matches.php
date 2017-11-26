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

  public static function getPartialDBMatches($id) {
    global $con;

    $query1 = mysqli_query($con, "SELECT * FROM matches WHERE tournament = ".(int)$id." AND status <> 4 ORDER BY mround ASC");

    $r = [];
    $r[0] = [];
    while ($row = mysqli_fetch_assoc($query1)) {
      $r[0][] = $row;
    }

    $query2 = mysqli_query($con, "SELECT * FROM matches WHERE tournament = ".(int)$id." AND status = 4 ORDER BY mround ASC");

    $r[1] = [];
    while ($row = mysqli_fetch_assoc($query2)) {
      $r[1][] = $row;
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

  public static function getDBMatrixs($match) {
    global $con;

    $query = mysqli_query($con, "SELECT * FROM matrixs WHERE internalmatch = ".(int)$match);

    $matrixs = [];

    while ($row = mysqli_fetch_assoc($query)) {
      $matrixs[] = $row;
    }

    return $matrixs;
  }

  public static function doFinish($match, $tournament) {
    $matrixs = self::getDBMatrixs($match["id"]);
    $scores = [0, 0];
    foreach ($matrixs as $matrix) {
      $scores[$matrix["winner"] - 1]++;
    }

    if ($scores[0] == $scores[1]) {
      return -1;
    }

    $winner = $match["player".($scores[0] > $scores[1] ? "1" : "2")];

    if (!api::uploadResults($match["challongeid"], $tournament, $scores, $winner)) {
      return -2;
    }

    if (!db::updateResults($match["id"], ($scores[0] > $scores[1] ? 1 : 2))) {
      return -3;
    }

    return 0;
  }
}
