<?php
session_name('current_session');
session_start();

$dbserv = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "PortalProject";

$error;

if(!empty($_POST['user']) && !empty($_POST['pass'])) {
  /*Setting Variables*/
  $user = $_POST['user'];
  $pass = $_POST['pass'];
} else {
  $error = "Error: Please fill in all the fields!";
  $_SESSION["error"] = $error;
  //header("Location: login.php");
}

try {
  $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "select password, uid, username
          from userbase
          where username = :username";

  $stmt = $conn->prepare($sql);
  $stmt->execute(['username' => $user]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  $UID = $result['uid'];
  $username = $result['username'];
  $password_hash = $result['password'];

  $dbname = ("$username-$UID");

  $conn = null;

  if(password_verify($pass, $password_hash)){
    //echo "pre-hash: $pass<br>pst-hash: $dbhash<br>";
    //echo "Valid!";

    $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "select uid, username, timestamp
            from userinfo
            where username = :username";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['username' => $user]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $UID = $result['uid'];
    $username = $result['username'];
    $timestamp = $result['timestamp'];

    $_SESSION['uid'] = $UID;
    $_SESSION['username'] = $username;
    $_SESSION['timestamp'] = $timestamp;

    ?>
  <document>
    <!DOCTYPE html>
    <html>
    <head>
      <title>Redirecting...</title>
      <link rel="stylesheet" type="text/css" href="assets/styles/style_default.css">
      <meta charset='utf-8'>
    </head>

    <body>
      <div class="container-center">
        <div class="login-pane">
        <br>
        <img src="assets/img/logos/logo_black.png" alt="Logo" width = 256>
        <br>
        <h2>Logging in | Please Wait...</h2>
        <br>
      </div>
    </div>
    </body>
    </html>
  </document>

    <?php
    header("refresh:3;url=home.php");

  }else{
    $error = "Error: Unable to verify password hash!";
    $_SESSION["error"] = $error;
    header("Location: login.php");
  }

} catch(PDOException $e) {
  echo "FATAL ERROR: " . $e->getMessage();
  $conn = null;
}
