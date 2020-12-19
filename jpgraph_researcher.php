<?php 
session_start();
$testName = $_SESSION['testName'];
$testNamePath = "data/" .$testName. ".csv";

require_once ('jpgraph/src/jpgraph.php');
require_once ('jpgraph/src/jpgraph_scatter.php');


$f = fopen($testNamePath, "r");
while (($line = fgetcsv($f)) !== false) {      
    list($datax[], $datay[], $datatime[]) = $line;
}
fclose($f);

$graph = new Graph(300,200,'auto');
$graph->SetScale("linlin");
 
$graph->img->SetMargin(50,50,50,50);        
$graph->SetShadow();
 
$graph->title->Set("Scatter plot of patient's data:");
$graph->title->SetFont(FF_FONT1,FS_BOLD);
 
$sp1 = new ScatterPlot($datay,$datax);
 
$graph->Add($sp1);
$graph->Stroke();



?>