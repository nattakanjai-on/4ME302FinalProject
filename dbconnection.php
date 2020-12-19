<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbName = "pd_assign2";

  try {
    $connect = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO:: ERRMODE_EXCEPTION);
    echo "Connection success!";
  }
  catch (PDOExecption $e) {
    echo "ERROR in connection" . $e->getMessage();
  }
   ?>
