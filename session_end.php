<?php
session_name('current_session');
session_start();
session_destroy();
sleep(1);
header("Location: login.php");
?>
<!DOCTYPE html>
<html>
<body>
<h1>LOGGING OUT!</h1>
</body>
</html>
