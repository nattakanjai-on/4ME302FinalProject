<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
require 'twitter-login-php/autoload.php';

//Connect to the Twitter OAuth account
$twitter_oauth=define( 'CONSUMER_KEY', 't6ONv3tw6Y1S8hfMOeGVQPxCd' ); 
$twitter_oauth=define( 'CONSUMER_SECRET', 'Gplya4ih8Lm04HQaw5sFR7mHkB83GwhfclKsNGu56EIlK18blN' );
$twitter_oauth=define( 'OAUTH_CALLBACK', 'http://localhost:8888/twitter_callback.php' );
?>

