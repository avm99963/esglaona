<?php
class tournaments {
  public static function getTournament($id) {
    global $con;

    $query = mysqli_query($con, "SELECT * FROM tournaments WHERE id = ".(int)$id) or die(mysqli_error($con));

    if (!mysqli_num_rows($query)) {
      return false;
    }

    return mysqli_fetch_assoc($query);
  }

  public static function getTournaments() {
    global $con;

    $query = mysqli_query($con, "SELECT * FROM tournaments");

    if (!mysqli_num_rows($query)) {
      return [];
    }

    $r = array();

    while ($row = mysqli_fetch_assoc($query)) {
      $r[] = $row;
    }

    return $r;
  }
}
