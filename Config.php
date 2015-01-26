<?php

 class Config
 {
     static public $oauth_access_token = "access_token";
     static public $oauth_access_token_secret   = "access_token_secret";
     static public $consumer_key  = "consumer_key";
     static public $consumer_secret    = "consumer_secret";
     static public $mvc_url_search_twitter = "https://api.twitter.com/1.1/search/tweets.json";
     static public $mvc_url_update_twitter = "https://api.twitter.com/1.1/statuses/update.json";
     static public $mvc_url_embed_twitter = "https://api.twitter.com/1.1/statuses/oembed.json";
     
     static public $mvc_srch_word1     = "Palabra de busqueda 1";
     static public $mvc_srch_word2 = "Palabra de busqueda 2";
     static public $mvc_srch_user1 = "usuarioTwitter1";
     static public $mvc_srch_user2     = "usuarioTwitter2";
     static public $mvc_srch_user3 = "usuarioTwitter3";
     static public $mvc_srch_user4 = "usuarioTwitter4";
     static public $mvc_srch_user5 = "usuarioTwitter5";
     static public $mvc_hash_rtweet = "#Hashtag MT @";
     
     static public $mvc_fecha_inicio = "-3 day";
     static public $mvc_fecha_fin = "now";
 }

