<!DOCTYPE html>
<html>
<head>
    <title>Output</title>
</head>
<body>

<?php
// Check if data parameter is set in the URL
if (isset($_GET["data"])) {
    // Retrieve and display the output data
    $outputData = urldecode($_GET["data"]);
    echo nl2br($outputData); // Use nl2br to preserve line breaks in HTML
} else {
    // Display a message if data parameter is not set
    echo "No data available.";
}
?>

</body>
</html>
