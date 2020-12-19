<?php

//Connect with Google OAuth account
require_once "google_config.php";

//Get code if there's no code and add it into session "access_token"
if (isset($_GET['code'])) {
    $token = $g_client->fetchAccessTokenWithAuthCode($_GET['code']);
    $_SESSION['access_token'] = $token;

} else { //If the user does not have access, gets directed to login page
    header('Location: login.php');
    exit();
}
    //If the user has access - Get data from user and save it into session "email"
    $objOAuthService = new Google_Service_Oauth2($g_client);
    $userData = $objOAuthService->userinfo_v2_me->get();
    $_SESSION['email'] = $userData['email'];

    //Redirect the user to "google_patients" page if they have access
    header('Location: google_patients.php');
    exit();
?>