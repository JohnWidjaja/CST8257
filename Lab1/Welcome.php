<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>
<?php
// set time zone
date_default_timezone_set("America/Toronto");

// get current date in the format of YYYY-MM-DD
$today = date ("y-m-d");
?>
<h2>Welcome to PHP!</h2>

<!--display current date-->
Today is <?php print( $today ); ?>
</body>
</html>

