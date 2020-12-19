<?php
session_start();
require_once "twitter_config.php";
require 'twitter-login-php/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

//Check if the user have an access token
if ( isset( $_SESSION['twitter_access_token']) && $_SESSION['twitter_access_token']) {
   
   //yes - get's access
    $isLoggedIn = true;	
    
   //Coming from twitter callback URL
} elseif ( isset( $_GET['oauth_verifier']) && isset( $_GET['oauth_token']) && isset( $_SESSION['oauth_token']) && $_GET['oauth_token'] == $_SESSION['oauth_token'] ) { 

    //Setup connection to Twitter with request token
    $connection = new TwitterOAuth( CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret'] );
    
    //Get an access token
    $access_token = $connection->oauth( "oauth/access_token", array( "oauth_verifier" => $_GET['oauth_verifier']));

    //Save access token to the session
    $_SESSION['twitter_access_token'] = $access_token;

    //User is logged in
    $isLoggedIn = true;

} else { //If the user is not authorized with the app - connect to twitter with app creds
    $connection = new TwitterOAuth( CONSUMER_KEY, CONSUMER_SECRET );

    //Get a request token from twitter
    $request_token = $connection->oauth( 'oauth/request_token', array('oauth_callback' => OAUTH_CALLBACK));

    //Save Twitter token info to the session
    $_SESSION['oauth_token'] = $request_token['oauth_token'];
    $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];

    //User is logged in
    $isLoggedIn = false;
}

//If the user is logged in
if ( $isLoggedIn ) { 

    //Get token info from session
    $oauthToken = $_SESSION['twitter_access_token']['oauth_token'];
    $oauthTokenSecret = $_SESSION['twitter_access_token']['oauth_token_secret'];

    //Setup connection
    $connection = new TwitterOAuth( CONSUMER_KEY, CONSUMER_SECRET, $oauthToken, $oauthTokenSecret );
    $params = array('include_email' => 'true', 'include_entities' => 'false', 'skip_status' => 'true');

    //User Twitter connection to get userinfo
    $user = $connection->get( "account/verify_credentials", $params );
    $_SESSION['email'] = $user->email;
    
    //Send the user to "twitter_physician" page if they have access
    header('Location: twitter_physician.php');
    exit();

//If not logged in, get and display the login with twitter link (added in the login page)
} else { 
    $url = $connection->url( 'oauth/authorize', array( 'oauth_token' => $request_token['oauth_token'] ) );
}
?>
