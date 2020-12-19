<?php
    
    session_start();

    //Check if there's an access token saved in sessions
    if (!isset($_SESSION['access_token'])) {
        //If not, send the user to the login page
        header('Location: homepage.php');
        exit();
    }
    //Check if there's an email saved in session "email"
     if (isset($_SESSION['email'])) {

        $emailData = $_SESSION['email'];

         //Connect to the database
        $connection=mysqli_connect("localhost", "root", "root", "pd_assign2");

        //Get emailinfo from the User table in database 
        $dbuserinfo=mysqli_query($connection, "SELECT * FROM User WHERE email='" .$emailData. "'");
        
        //Number of rows in email query
        $emailrows=mysqli_num_rows($dbuserinfo);

        //Check if $emailrows is bigger than 0
        if ($emailrows>0) {

        } else {
        }
    }   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Nattakan Jai-On">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;500&display=swap" rel="stylesheet">
    <title>4ME302 - Final Project</title>
</head>
<body>
<h1>PATIENT DATA</h1>
<?php

include "patient_dbconnect.php";
$db = new DbConnect();
$conn = $db->connect();

//Present videos
$stmt = $conn->prepare("SELECT * FROM Videos WHERE video_type = 2");
$stmt->execute();
$playlists = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($playlists as $video) {
    echo "<div class='youtube'>";
    echo "<h2>".$video['title']. "</h2>";
    echo "<br>";
    echo '<iframe width="585" height="415" 
    src="https://www.youtube.com/embed/?listType=playlist&list='.$video['video_id'].'" 
    frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; g
    yroscope; picture-in-picture" allowfullscreen></iframe>';
    echo "<br><br>";

}
echo "<h2> Below is your date time exercise <br> </h2>";
?>
    <form method="post" action="google_jpgraph.php" target="iframe" enctype="multipart/form-data">
            <input type="submit" name="submit" value="Show data"></input><br><br>
                <br>
                <iframe name="iframe" frameborder="0" width="585" height="315" allowfullscreen >
                <img src="google_jpgraph.php"/>
                </iframe>
            </form>
            <div class="logout">
                Click <a href='homepage.php'>here</a> to logout
            </div>
         </div>
    </body>
</html>

<?php

/*
//Get playlist with excercise videos from YouTube via Web API ONCE

include "patient_dbconnect.php";
$db = new DbConnect();
$conn = $db->connect();

$key = "AIzaSyCSuFN0kxraCEcVBclcMmmTBPOrwSDPkYA";
$base_url = "https://www.googleapis.com/youtube/v3/";
$channelId = "UCWz2fkogu9o1D8rnShf4riA";
$maxResult = 10;
//$video_type = !isset($_GET['vtype']) ? 1 : 2;

$API_URL = $base_url . "playlists?order=date&part=snippet&channelId=".$channelId. 
"&maxResults=". $maxResult. "&key=".$key;

//function getPlaylist() {

$playlists = json_decode( file_get_contents($API_URL));

    foreach($playlists->items as $video) {

        $sql = "INSERT INTO `Videos` (`id`, `video_type`, `video_id`, `title`, 
                `thumbnail_url`) 
                VALUES (NULL, 2, :vid, :title, :turl)";
    
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":vid", $video->id);
        $stmt->bindParam(":title", $video->snippet->title);
        $stmt->bindParam(":turl", $video->snippet->thumbnails->high->url);
        //$stmt->bindParam(":pdate", $video->snippet->publishedAt);
        
        $stmt->execute();
        echo "Playlists data saved!";

    }
*/