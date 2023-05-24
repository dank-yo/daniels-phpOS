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
  <link rel="stylesheet" type="text/css" href="styles/terminal-style-sheet.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset='utf-8'>

  <style>
    *{margin: 0px;padding: 0px; color: #00ff00}
    table, tr, th, td{margin: 0px; padding: 0px; text-align: left; vertical-align: top;}
    table{width: 100%; height: 100vh;}
  </style>
</head>

<body style='overflow-x: hidden; overflow-y: scroll'>
  <div style='padding: 8px;'>
    <table>
      <tr style='height: 5%'>
        <td style='height: 5%'>
        <div style='display: inline; height: 5%'>
          <div style='display: inline-block;'>
            <p>WebOS$<?php echo($user);?>:_></p>
          </div>
          <div style='display: inline-block; width: 80%; height: 5%'>
            <form method = "post" action="terminal_action.php">
              <input type='text' name='terminal_input'></input>
            </form>
          </div>
        </div>
      </th>
    </tr>
    <?php
    
    ?>
    </table>
</body>
</html>

<?php


?>
