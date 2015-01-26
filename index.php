<?php
header('Content-Type: text/html; charset=UTF-8');
ini_set('display_errors', 1);
require_once __DIR__ .'/Config.php';
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

//Url de para twitear
$urlRT = Config::$mvc_url_update_twitter;
$requestMethodRT = 'POST';

$twitter = new TwitterAPIExchange($settings);
$twitter->buildOauth($urlRT, $requestMethodRT);

$contTweet = count($result['statuses'])-1;


For($i=$contTweet;$i>=0;$i--){
    $short = checkTweet($result['statuses'][$i]['text'], $result['statuses'][$i]['user']['screen_name']);
    $mensaje = Config::$mvc_hash_rtweet.$result['statuses'][$i]['user']['screen_name']." ".$short;
    
    $postfields = array(
        'status' => $mensaje, 
    ); 

    //Retweets de los tweets encontrados
    $twitter->setPostfields($postfields)->performRequest();   
    
    //Imprime en pantalla los retweets
    echo $result['statuses'][$i]['created_at']." $mensaje <br>";
}

function checkTweet($mensaje, $username){
    
    //Recorta los tweets de manera que los retweets no ocupen más de 140 caracteres. 
    //Compueba si hay un enlace a una URL al final del tweet y lo tiene en cuenta para que siempre aparezca en el retweet

    $longUser = strlen($username);
    $longText = strlen($mensaje);
    $longHashRtweet = strlen(Config::$mvc_hash_rtweet);
    
   $longTotal = $longUser+$longHashRtweet+3;
    
    if($longText + $longUser + $longHashRtweet >=140){
        $porciones = explode(" ", $mensaje);
        $ultValor = count($porciones)-1;
        if(substr($porciones[$ultValor],0,4)== "http"){
            $long_ultValor = strlen($porciones[$ultValor]);
            $twt = substr($mensaje,0,140-$long_ultValor-$longTotal-2);
            return $twt."... ".$porciones[$ultValor];
            
        }else{
            $twt = substr($mensaje,0,140-$longTotal-1);
            return $twt."...";
        }
     
    }
    return $mensaje;
}
?>