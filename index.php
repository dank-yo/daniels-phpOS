<?php
session_name('current_session');
session_start();
header("Location: ./home.php");
?>