<?php
if (isset($_GET["codename"])) {
  header("Content-Type: image/svg+xml");
  echo file_get_contents("http://challonge.com/".urlencode($_GET["codename"]).".svg");
}
