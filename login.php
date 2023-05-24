<?php
session_name('current_session');
session_start();

$dbserv = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "Project";
?>

<!doctype html>
<html>

<head>
  <title>WebOS</title>
  <link rel="stylesheet" type="text/css" href="assets/styles/style_default.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset='utf-8'>
</head>

<body>
  <div class="container-center">
    <?php
    if(isset($_SESSION["error"])){ ?>
    <br>
    <div class="login-pane-error" style="text-alignt: center; color: red;">
      <?php
        $error = $_SESSION["error"];
        echo "<span>$error</span>";
      }
      ?>
    <div class="login-pane">
      <br>
      <h1>Login</h1>
      <br>
      <form method = "post" action ="login_form.php">
          username: <input type='text' name='user'><br><br>
          password: <input type='password' name='pass'><br><br>
          <div style="display: inline-block;">
            <input type='submit' class='login-button'>
            <input type="button" class='login-button' value="Register" onclick="window.location.href='register.php'"/>
          </div>
      </form>
      <br>
    </div>
  </div>
  </div>
</body>
</html>

<?php
    unset($_SESSION["error"]);
?>
