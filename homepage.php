<?php

if(isset($_SESSION)) {
    session_destroy();
    session_start();
    $_SESSION = array();
}
if(!isset($_SESSION)) {
    session_start();
    $_SESSION = array();

}
require_once "google_config.php";
$google_url = $g_client->createAuthUrl();

include 'twitter_callback.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Nattakan Jai-On">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;500&display=swap" rel="stylesheet">
    <title>4ME302 - Final Project</title>
</head>
<body>
    <h1>Welcome to your login page!</h1><br>
    <form >
    <div class="wrapper">

    <div class = "google" >
    If you're a Patient, please log in below by clicking on Google: <br><br>
    <input type="button" onclick="window.location = '<?php echo $google_url; ?>'" value="Google">
    </div>

    <div class = "twitter">
    If you're a Physician, please log in below by clicking on Twitter: <br><br>
    <input type="button" onclick="window.location.href = '<?php echo $url; ?>'" value="Twitter">
    </div>

    <div class='github'>
    If you're a Researcher, please log in below by clicking on GitHub: <br><br> 
    <input type='button' onclick="window.location.href ='https://github.com/login/oauth/authorize?client_id=1ebffdaa62744949dbf3&scope=user:email'" value='GitHub'>
    </div>
        </form>
        </div>
    </body>
</html>

