<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Nattakan Jai-On">
    <link rel="stylesheet" href="">
    <title>Assignment 2</title>
</head>
<body>
<div class="wrapper">
<?php
echo "<h2>Data (5) for: Patient 2</h2>";
echo "<table border='1px' cellpadding='6' cellspacing='50'>\n";
$f = fopen("data5.csv", "r");
while (($line = fgetcsv($f)) !== false) {
        echo "<tr>";
        foreach ($line as $cell) {
                echo "<td>" . htmlspecialchars($cell) . "</td>";
        }
        echo "</tr>\n";
}
fclose($f);
echo "\n</table>";
?>
</div>
</body>
</html>
