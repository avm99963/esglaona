<?php
class visual {
  public static function breadcumb($bread) {
    $links = [];

    $length = count($bread);

    foreach ($bread as $i => $piece) {
      if ($i + 1 == $length) {
        $links[] = "<b>".$piece."</b>";
      } else {
        $links[] = "<a href='".$piece[0]."'>".$piece[1]."</a>";
      }
    }

    echo "<p>".implode(" > ", $links)." <span style='float: right;'><a href='logout.php'>Sign out</a></span></p><hr>";
  }

  public static function url($normal, $cool="") {
    global $conf;

    if ($cool == "") {
      $cool = $normal;
    }
    
    return $conf["path"].($conf["coolURLs"] ? $normal : $cool);
  }

  private static $colors = [
    "success" => "green",
    "error" => "red",
    "warning" => "orange"
  ];

  public static function msg($array) {
    global $_GET;

    if (!isset($_GET["msg"])) {
      return;
    }

    foreach ($array as $msg) { 
      if ($msg[0] == $_GET["msg"]) {
        echo "<p style='color: ".self::$colors[$msg[2]]."'>".$msg[1]."</p>";
      }
    }
  }
}
