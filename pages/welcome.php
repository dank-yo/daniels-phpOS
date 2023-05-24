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
  <link rel="stylesheet" type="text/css" href="styles/welcome-style-sheet.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset='utf-8'>
  <style>
    body{
      overflow-y: scroll;
    }
  </style>
</head>

<body>
  <div class='main-body'>
    <div id='head'>
      <h1>Welcome!</h1>
      <h4>Build Version 0.1</h4>
    </div>
    <div id='container'>
      <p>Purpose: The purpose of something like this would be a browser portal to a personal database/server.</p>
      <p>Obviously, this is incredibly resource intenstive and a select-group of people with access to the portal may struggle with performance.</p>
      <p>This was mostly done to see what I could do with everything I have learned so far this year, obviously there are better ways to do this and better formats, I just wanted to design an 'OS-like' interface.</p>
      <p> -Dan Kasnick</p>
      <p>Build 0.1 Features</p>
      <ul>
        <li>Window based user interface with moveable UI</li>
        <li>Basic Terminal</li>
        <li>Basic 'File Explorer'</li>
        <li>Basic Web Browser</li>
        <li>Basic Text Editor</li>
        <li>System Preferences</li>
      </ul>
    </div>
</body>
</html>
