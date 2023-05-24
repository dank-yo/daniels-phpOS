<?php
session_name('current_session');
session_start();

$dbserv = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "Project";

$UID = $_SESSION['uid'];
$user = $_SESSION['username'];
$timestamp = $_SESSION['timestamp'];


?>

<!doctype html>
<html>
<head>
  <title>WebOS</title>
  <link rel="stylesheet" type="text/css" href="styles/explorer-style-sheet.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset='utf-8'>
</head>

<body>
  <div class='main-body'>
    <div class='container'>

    </div>
</body>
</html>

<?php


?>
