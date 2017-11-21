<?php
class api {
  private static function request($url, $method="GET", $params="") {
    if ($method == "GET") {
      $response = file_get_contents($url);
    } else {
      $ch = curl_init();

      curl_setopt($ch, CURLOPT_URL, $url);
      if ($method == "POST") {
        curl_setopt($ch, CURLOPT_POST, 1);
      } elseif ($method == "PUT") {
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
      }

      curl_setopt($ch, CURLOPT_POSTFIELDS, $params); // $params = "adria=1&vilanova=0"

      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      $response = curl_exec($ch);

      curl_close($ch);
    }

    $json = json_decode($response, true);

    return (json_last_error() == JSON_ERROR_NONE ? $json : false);
  }

  const API_URL = "https://api.challonge.com/v1/";

  public static function getTournament($codename) {
    global $conf;

    return self::request("https://api.challonge.com/v1/tournaments/".urlencode($codename).".json?api_key=".urlencode($conf["challonge"]["apiKey"]));
  }

  public static function getMatches($codename) {
    global $conf;

    return self::request("https://api.challonge.com/v1/tournaments/".urlencode($codename)."/matches.json?api_key=".urlencode($conf["challonge"]["apiKey"]));
  }

  public static function getMatch($codename, $match) {
    global $conf;

    return self::request(self::API_URL."tournaments/".urlencode($codename)."/matches/".urlencode($match).".json?api_key=".urlencode($conf["challonge"]["apiKey"]));
  }

  public static function getParticipants($codename) {
    global $conf;

    return self::request("https://api.challonge.com/v1/tournaments/".urlencode($codename)."/participants.json?api_key=".urlencode($conf["challonge"]["apiKey"]));
  }

  public static function getArrayParticipants($codename) {
    $participants_c = self::getParticipants($codename);

    $participants = [];
    foreach ($participants_c as $participant) {
      $participants[$participant["participant"]["id"]] = $participant["participant"]["name"];
    }

    return $participants;
  }

  public static function addAttachment($match) {
    global $conf;

    $matchid = $match["match"]["id"];
    $tournamentid = $match["match"]["tournament_id"];

    return self::request(self::API_URL."tournaments/".urlencode($tournamentid)."/matches/".urlencode($matchid)."/attachments.json?api_key=".urlencode($conf["challonge"]["apiKey"]), "POST", "api_key=".urlencode($conf["challonge"]["apiKey"])."&match_attachment[url]=".urlencode($conf["pathForChallonge"]."match.php?id=".$matchid));
  }

  public static function uploadResults($match, $tournament, $scores, $winner) {
    global $conf;

    return self::request(self::API_URL."tournaments/".urlencode($tournament)."/matches/".urlencode($match).".json?api_key=".urlencode($conf["challonge"]["apiKey"]), "PUT", "api_key=".urlencode($conf["challonge"]["apiKey"])."&match[scores_csv]=".urlencode($scores[0]."-".$scores[1])."&match[winner_id]=".urlencode($winner));
  }
}
