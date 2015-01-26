<?php
header('Content-Type: text/html; charset=UTF-8');
ini_set('display_errors', 1);
require_once __DIR__ .'/Config.php';
//require_once ('Config.php');
//require_once('TwitterAPIExchange.php');
require_once __DIR__ .'/TwitterAPIExchange.php';

//Se establecen las credenciales para twitter
$settings = array(
    'oauth_access_token' => Config::$oauth_access_token,
    'oauth_access_token_secret' => Config::$oauth_access_token_secret,
    'consumer_key' => Config::$consumer_key,
    'consumer_secret' => Config::$consumer_secret,
);

//Url de busqueda de Twitter
$url = Config::$mvc_url_search_twitter;
$requestMethod = 'GET';
 
//Filtros sobre la busqueda a realizar (nombre del hashtag, número de tweet por consulta, tipo de resultado, etc)
$getfield = "?q=".Config::$mvc_srch_word1."%20OR%20".Config::$mvc_srch_word2."%20"
        . "from%3A".Config::$mvc_srch_user1."%20OR%20from%3A".Config::$mvc_srch_user2."%20OR%20from%3A".Config::$mvc_srch_user3."%20OR%20from%3A".Config::$mvc_srch_user4."%20OR%20from%3A".Config::$mvc_srch_user5."%20"
        . "since%3A".date("Y-m-d",strtotime(Config::$mvc_fecha_inicio))."%20until%3A".strtotime(Config::$mvc_fecha_fin)."&src=typd";

$twitter = new TwitterAPIExchange($settings);
$json = $twitter->setGetfield($getfield)
        ->buildOauth($url, $requestMethod)
        ->performRequest();
$result = json_decode($json,TRUE);

//Url de para incrustar tweets
$urlRT = Config::$mvc_url_embed_twitter;

foreach($result['statuses'] as $tweet)
{
    $getId ="?id=".$tweet['id_str'];
    
    $jsonEmb = $twitter->setGetfield($getId)->buildOauth($urlRT, $requestMethod)
            ->performRequest();
    
    $resultEmb = json_decode($jsonEmb,TRUE);
    
    echo $resultEmb['html'];    
}

?>