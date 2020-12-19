<?php
  if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 
  require_once "vendor/autoload.php";

  //Connect to Google Oauth account
  $g_client = new Google_Client();
  $g_client->setClientId("738040331846-4sf03gdkuicbqc5b6fqtodl6oc65a04m.apps.googleusercontent.com");
  $g_client->setClientSecret("TFkBBIXp8YGhS3ENpBPlIEe0");
  $g_client->setApplicationName("Web client 1");
  $g_client->setRedirectUri("http://localhost:8888/google_callback.php");
  $g_client->addScope("https://www.googleapis.com/auth/plus.login https://www.googleapis.com/auth/userinfo.email");
?>