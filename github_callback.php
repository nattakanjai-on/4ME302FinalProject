<?php
session_start(); 

if(!isset($_SESSION)) 
  { 
      session_start(); 
  } 

$code = $_GET['code'];

//Check if code is empty is session
if ($code == "") {

}
  //Connect to GitHub Oauth account
  $CLIENT_ID = "1ebffdaa62744949dbf3";
  $CLIENT_SECRET = "3b1eb13ef9e2163f62416e1a0ea992ef1a9c314c";
  $URL = "https://github.com/login/oauth/access_token";
  
  //GitHub config
  $postParams = [
    'client_id' => $CLIENT_ID,
    'client_secret' => $CLIENT_SECRET,
    'code' => $code
];

 //Curl function to post userinfo 
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_URL,$URL);
 curl_setopt($ch, CURLOPT_POST, 1);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $postParams);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));
 $response = curl_exec($ch);
 curl_close ($ch);
 $data = json_decode($response);

//Check if data is null
if ($data->access_token != "") {
    
    //If yes - Store data in sessions "access token"
    $_SESSION['access_token'] = $data->access_token;

} else {

    //If there's data - redirect the user to the "github_researcher" page
    header('Location: http://localhost:8888/github_researcher.php');
    exit;
}
  
//Curl function to get userinfo
$cURLConnection = curl_init();
curl_setopt($cURLConnection, CURLOPT_URL, 'https://api.github.com/user?access_token='.$_SESSION['access_token'] );
curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded","User-Agent: Demo","Accept: application/json","Authorization: token ".$_SESSION['access_token']));
$gitResponse = curl_exec($cURLConnection);
curl_close($cURLConnection);
$gitUser = json_decode($gitResponse);

//Save userinfo in the session "email"
$_SESSION['email'] = $gitUser->email;

//Send the researcher user to the "github_researcher" page
header('Location: http://localhost:8888/github_researcher.php');
exit;

?>
