<?php
    session_start();

    //Check if there's an access token saved in sessions
    if (!isset($_SESSION['twitter_access_token'])) {

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
            //If the user's email doesn't match the email in the database - send the user to the login page
            header('Location: homepage.php');
            exit();
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
<div class="pdata">

    <div class="dropdown">
    <form action="" method="post">
    <select name="patientdropdown" id="dropdown">
    <option value="" selected> - Choose your patient -
        <?php
        $db = mysqli_connect("localhost", "root", "root", "pd_assign2");
        $res = mysqli_query($db, "SELECT username FROM User WHERE Role_IDrole=1");

        while($row = mysqli_fetch_array($res)) {
            $name = $row['username']; 
            echo '<option value="'.$name.'">'.$name.'</option>';
        }
        ?>
        <label for="dropdown">Select</label>
        </select>
        <input type="submit" name="submit" value="Get patient data"></input>
        </form>
    </div>

    <?php
    if(isset($_POST['submit'])){
    if(!empty($_POST['patientdropdown'])) {

        $selected = $_POST['patientdropdown'];
        
        $db = mysqli_connect("localhost", "root", "root", "pd_assign2");
        $userinfo="SELECT * FROM User WHERE username='" .$selected. "'";
        
        $emailrows = mysqli_query($db,$userinfo);
        $result = $db->query($userinfo);

        echo "<h2>Patient info:</h2>";
        while($row = $result->fetch_assoc()) {
            echo "<h3>userID: ".$row["userID"] ."</h3>";
            $userID = $row["userID"];
            echo "<h3>Username: ".$row["username"]."</h3>"; 
            echo "<h3>Email: ".$row["email"]. "</h3>";
        
          }
        
        $orginfo="SELECT name FROM Organization WHERE organizationID=1";
        $orgrows = mysqli_query($db,$orginfo);
        $orgresult = $db->query($orginfo);
  
          while($row2 = $orgresult->fetch_assoc()) {
            echo "<h3>Organization: ".$row2["name"]. "</h3>";
    
    ?>
    <div class="graph">
    <form method="post" action="jpgraph_scatterplot.php" target="iframe" enctype="multipart/form-data">
    <select name="datagraph" id="dropdown">
    <option value="" selected> - Choose data -
        <?php
        $db = mysqli_connect("localhost", "root", "root", "pd_assign2");
        $graphData = mysqli_query($db, "SELECT DataURL FROM Test_Session WHERE patient_userID='" .$userID. "'");

        while($row = mysqli_fetch_array($graphData)) {
            $url = $row['DataURL']; 
            echo '<option value="'.$url.'">'.$url.'</option>';
        }
        ?>
            <label for="dropdown">Select</label>
            </select>
            <input type="submit" name="submit" value="Get data"></input>

            <div class="ima-graph">
                <iframe name="iframe" frameborder="0" width="320" height="220" allowfullscreen>
                <img src="jpgraph_scatterplot.php"/>
                </iframe>
            </div>
            </form>
            <div class="logout">
                Click <a href='homepage.php'>here</a> to logout
            </div>
        </div>
    </div>
    <?php
        }
    }

    } else {
        }
    ?>   
        </div>
    </div>
</body>
</html>