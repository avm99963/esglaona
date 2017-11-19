<?php
class db {
  public static function escape($str, $html=true) {
    global $con;

    return ($html ? mysqli_real_escape_string($con, htmlspecialchars($str)) : mysqli_real_escape_string($con, $str));
  }

  public static function addTournament($codename) {
    global $con;

    $codename_escaped = self::escape($codename, false);
    $tournament = api::getTournament($codename);
    $tournament_name = self::escape($tournament["tournament"]["name"]);

    if (mysqli_query($con, "INSERT INTO tournaments (codename, name, current_round) VALUES ('".$codename_escaped."', '".$tournament_name."', 1)")) {
      return true;
    } else {
      echo mysqli_error($con);
      return false;
    }
  }

  public static function getUsers() {
    global $con, $conf;

    $query = mysqli_query($con, "SELECT id, username, type FROM users");

    $usuaris = [];

    while ($row = mysqli_fetch_assoc($query)) {
      $usuaris[] = $row;
    }

    return $usuaris;
  }

  public static function addUser($username, $password, $type) {
    global $con;

    if ($type > 2 || $type < 0) {
      return false;
    }

    $u = self::escape($username, false);
    $p = password_hash($password, PASSWORD_DEFAULT);
    $t = (int)$type;

    return mysqli_query($con, "INSERT INTO users (username, password, type) VALUES ('".$u."', '".$p."', ".$t.")");
  }

  public static function addMatch($match, $tournament, $datetime) {
    global $con;

    $id = (int)$match["match"]["id"];
    $tournament = (int)$tournament;
    $schedule = strtotime($datetime);
    $player1 = (int)$match["match"]["player1_id"];
    $player2 = (int)$match["match"]["player2_id"];
    $round = (int)$match["match"]["round"];

    if (!api::addAttachment($match)) {
      return false;
    }

    return mysqli_query($con, "INSERT INTO matches (challongeid, status, schedule, player1, player2, mround, tournament) VALUES (".$id.", 2, ".$schedule.", ".$player1.", ".$player2.", ".$round.", ".$tournament.")");
  }

  public static function changeCurrentRound($tournament, $round) {
    global $con;

    return mysqli_query($con, "UPDATE tournaments SET current_round = ".(int)$round." WHERE id = ".(int)$tournament." LIMIT 1");
  }

  public static function applyForMatch($match, $doit) {
    global $con, $_SESSION;

    if ($doit === true) {
      return mysqli_query($con, "INSERT INTO judges (internalmatch, user) VALUES (".(int)$match.", ".(int)$_SESSION["id"].")");
    } else {
      return mysqli_query($con, "DELETE FROM judges WHERE internalmatch = ".(int)$match." AND user = ".(int)$_SESSION["id"]." LIMIT 1");
    }
  }

  public static function modifyMatch($match, $datetime) {
    global $con;

    $schedule = strtotime($datetime);
    $id = (int)$match;

    return mysqli_query($con, "UPDATE matches SET schedule = ".$schedule." WHERE id = ".$id);
  }
}
