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
<div class="pdata">
    <div class="dropdown" >
    <form method="post" action="" enctype="multipart/form-data">
        <select name="dataDropdown" id="dropdown">
        <option value="" selected> - Choose data -
            <?php
            $db = mysqli_connect("localhost", "root", "root", "pd_assign2");
            $graphData = mysqli_query($db, "SELECT DataURL FROM Test_Session");

            while($row = mysqli_fetch_array($graphData)) {
                $url = $row['DataURL']; 
                echo '<option value="'.$url.'">'.$url.'</option>';
            }
                ?>
            <input type="submit" name="dataSubmit" value="Get data"></input>
        </form>
    </div>
<?php
    session_start();

    //Check if there's an access token saved in sessions
    if (!isset($_SESSION['access_token'])) {
    
        //If not, send the user to the login page
        header('Location: homepage.php');
        exit();
    }
    
    if (isset($_POST['dataDropdown']) || isset($_SESSION['testName'])) {

        if (isset($_POST['dataDropdown'])) {
            if ($_POST['dataDropdown'] == "") {
                echo '<div class="logout">Click <a href="homepage.php">here</a> to logout</div>';
                return;
            }

            $dataURL =$_POST['dataDropdown'];
            $_SESSION['testName'] = $_POST['dataDropdown'];
        } else {
            $dataURL =$_SESSION['testName'];
        }

        $db = mysqli_connect("localhost", "root", "root", "pd_assign2");
        $patientinfoQuery="SELECT patient_userID, test_SessionID FROM Test_Session WHERE DataURL='" .$dataURL. "'";

        $resultPatientID = $db->query($patientinfoQuery);

        while($row = $resultPatientID->fetch_assoc()) {
            $patientID = $row["patient_userID"];
            $testSessionID =  $row["test_SessionID"];
        }
            
            $db = mysqli_connect("localhost", "root", "root", "pd_assign2");
            $userinfo="SELECT * FROM User WHERE userID='" .$patientID. "'";
            
            $result = $db->query($userinfo);

            echo "<h2>Patient info:</h2>";
            while($row = $result->fetch_assoc()) {
                echo "<h3>userID: ".$row["userID"] ."</h3>";
                $userID = $row["userID"];
                echo "<h3>Username: ".$row["username"]."</h3>"; 
                echo "<h3>Email: ".$row["email"]. "</h3>";
                $userOrganizationID = $row["Organization"];
            
            }
            
            $orginfo="SELECT name FROM Organization WHERE organizationID='" .$userOrganizationID. "'";
            $orgrows = mysqli_query($db,$orginfo);
            $orgresult = $db->query($orginfo);
    
            while($row2 = $orgresult->fetch_assoc()) {
                echo "<h3>Organization: ".$row2["name"]. "</h3>";
            }
            
            echo "<h2>Test: $dataURL</h2>";
            echo '<form method="post" action="jpgraph_researcher.php" target="iframe" enctype="multipart/form-data">';
            echo    '<div class="ima-graph">';
            echo        '<iframe name="iframe" frameborder="0" width="320" height="220" allowfullscreen>';
            echo            '<img src="jpgraph_researcher.php"/>';
            echo        '</iframe>';
            echo    '</div>';
            echo    '<input type="submit" name="resultSubmit" value="View Results"></input>';
            echo '</form>';


            $userEmail = $_SESSION['email'];
            $db = mysqli_connect("localhost", "root", "root", "pd_assign2");
            $userQuery="SELECT userID, username FROM User WHERE email='" .$userEmail. "'";
            
            $userInfo = mysqli_query($db,$userQuery);

            while($row = $userInfo->fetch_assoc()) {
                $userID = $row["userID"];
                $username = $row["username"];
            }

            $db = mysqli_connect("localhost", "root", "root", "pd_assign2");
            $commentQuery = mysqli_query($db, "SELECT * FROM Data_Annotation WHERE test_SessionID='" .$testSessionID. "'");

            echo '<h2>Comments for Test Session: '.$dataURL.'</h2>';
            while($row = mysqli_fetch_array($commentQuery)) {
                echo    '<dl>';
                echo    '<dt>'.$username.' At '.$row["comment_date"].': </dt>';
                echo    '<dd>'.$row["comment"].'</dd>';
                echo    '</dl>';
                
            }

            echo '<form name="comment" action="" method="post">';
            echo    '<label for="com"></label>';
            echo    '<textarea id="comm" name="comm" rows="4" cols="50"></textarea><br><br>';
            echo    '<input type="submit" name="submitComment" value="Comment"></input><br>';
            echo '</form>';

        }

    if(isset($_POST['submitComment'])) {
    $comment = $_POST['comm'];
    $ID = (int)$userID;

    $db = mysqli_connect("localhost", "root", "root", "pd_assign2");
    $addComment = "INSERT INTO `Data_Annotation` (`test_SessionID`, `userID`, `comment`, `comment_date`) 
    VALUES ('$testSessionID','$ID', '$comment', CURRENT_TIMESTAMP)";

    $insertComm = mysqli_query($db, $addComment) or trigger_error("Query Failed! SQL: $addComment - Error: ".mysqli_error($db), E_USER_ERROR);

    if($insertComm) {
        echo "Your comment was successful!";
        header('Location: github_researcher.php');
            exit();
        }
    }
?>
    <div class="logout">
        Click <a href='homepage.php'>here</a> to logout
    </div>
</div>
</body>
</html>