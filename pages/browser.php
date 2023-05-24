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

$home='http://www.bing.com/';

if(!empty($_GET['urlInput'])){
  $_SESSION['url'] = $_GET['urlInput'];
}else{
  $_SESSION['url'] = $home;
}

?>

<!doctype html>
<html>
<head>
  <title>WebOS</title>
  <link rel="stylesheet" type="text/css" href="styles/browser-style-sheet.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset='utf-8'>

  <style>
  *{margin: 0px; padding: 0px; overflow: hidden;}
  iframe{width: 99.9%; height: 93vh; border: none;}

  </style>
</head>

<body>
  <div class='navbar' style='margin-left: 2px; margin-top: 2px; text-align: left; width: 100%; height: 32px;'>
    <div style='display: inline-block; text-align: left; max-width: 20%; height: 100%;'>
      <button style='border-radius: 5px; padding: 5px 8px;'>↩</button>
      <button style='border-radius: 5px; padding: 5px 8px;'>↪</button>
    </div>
    <div style='display: inline-block; text-align: left; width: 88%; height: 100%;'>
      <form method="get" href="browser.php?url=">
        <input style='width: 100%; padding: 5px 8px;' type='text' name='urlInput' value=<?php echo $_SESSION['url'];?> ></input>
      </form>
    </div>
  </div>
  <div>
    <iframe name='browser' src=<?php echo $_SESSION['url'];?> ></iframe>
  </div>
</body>
</html>
