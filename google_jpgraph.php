<?php 

session_start();
$patientEmail = $_SESSION['email'];

require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_bar.php');
$db = mysqli_connect("localhost", "root", "root", "pd_assign2");

$patientID = mysqli_query($db, "SELECT userID FROM User WHERE email='" .$patientEmail. "'");
$getPatientID = mysqli_fetch_assoc($patientID);

$ID = $getPatientID['userID'];
$testDate = mysqli_query($db, "SELECT testDateTime FROM Test_Session WHERE patient_userID='" .$ID. "'");

$arr = [];
$dates = [];

while($ligne=mysqli_fetch_assoc($testDate)) {
    array_push($dates, $ligne['testDateTime']);
    array_push($arr, 1);

}

$graph = new Graph(550,320,'auto');
$graph->SetScale("textlin");

$graph->yaxis->SetTickPositions(array(0,1,2), array(0.5,1.5));
$graph->SetBox(false);

$graph->ygrid->SetFill(false);
$graph->xaxis->SetTickLabels($dates);
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);

$b1plot = new BarPlot($arr);
$graph->Add($b1plot);


$b1plot->SetColor("white");
$b1plot->SetWidth(45);
$graph->title->Set("All dates of when you exercised:");

// Display the graph
$graph->Stroke();

?>