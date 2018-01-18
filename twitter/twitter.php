<?php
require_once("TwitterAPIExchange.php");
	$settings = array(
    		'oauth_access_token' => "2814928212-gc4pxbAmvs1VZVLkkt01RkjrB601YOboepkm8zI",
    		'oauth_access_token_secret' => "RdkEWG0tlxsaeBgLdytHpHKNVW4mqPKYpsTc1si5H8Dyu",
    		'consumer_key' => "jV5PWWL0LxKVKZQoPrJPjzVPr",
    		'consumer_secret' => "Y3YsNVA3v8w8jUhqEde6fa8tvsrtVtE25AwckjqH0ozkhIFm53"
	);

$url = 'https://api.twitter.com/1.1/statuses/update.json';
$requestMethod = "POST";
$postfields = array(
    		'screen_name' => 'usernameToBlock', 
    		'skip_status' => '1'
		);

$postfields = array(
    'status' => 'This is an amazing interface once again', 
	);

$twitter = new TwitterAPIExchange($settings);
$result = $twitter->buildOauth($url, $requestMethod)
             ->setPostfields($postfields)
             ->performRequest();

$decoded =  json_decode($result);
var_dump($decoded);
?>