<?php
session_name('current_session');
session_start();

$dbserv = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "PortalProject";

$tablename='userbase';

$error;

$userID = rand(30,999999);

if(!empty($_POST['user']) && !empty($_POST['pass']) && !empty($_POST['email'])) {
  /*Setting Variables*/
  $user = $_POST['user'];
  $pass = $_POST['pass'];
  $email = $_POST['email'];
  $username=$user;
  $password=password_hash($pass, PASSWORD_DEFAULT);
  $UID=$userID;
  $timestamp = date('Y-m-d H:i:s');
}

try {
  if(empty($user) || empty($pass)){
    $error = "Error: Please fill in all the fields!";
    $_SESSION["error"] = $error;
    header("Location: register.php");
  }
  /*Insert Encrypted user info to main database for verifying*/
  $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $data = [
    'uid' => $UID,
    'username' => $username,
    'password' => $password,
  ];

  $sql = "insert into userbase (uid, username, password)
          values (:uid, :username, :password)";

  $stmt = $conn->prepare($sql);
  $stmt->execute($data);
  $conn = null;

  /*Create User Database*/
  $conn = new PDO("mysql:host=$dbserv", $dbuser, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $usrdbname = "$username-$UID";

  $sql = "create database `$usrdbname`";

  $stmt = $conn->prepare($sql);
  $stmt->execute($data);
  //$res = $stmt->fetch(PDO::FETCH_ASSOC);

  $conn=null;

  /*Create UserInfo Table to store user information such as email*/
  $conn = new PDO("mysql:host=$dbserv;dbname=$usrdbname", $dbuser, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql = "create table userinfo (
          uid INT(6),
          username TEXT(50) NOT NULL,
          password TEXT(255) NOT NULL,
          email TEXT(60) NOT NULL,
          timestamp TEXT(20)
          )";

  $conn->exec($sql);

  $data = ['uid' => $UID,
           'username' => $username,
           'password' => $password,
           'email' => $email,
           'timestamp' => $timestamp,
          ];

  $sql = "insert into userinfo (uid, username, password, email, timestamp)
          values (:uid, :username, :password, :email, :timestamp)";

  $stmt = $conn->prepare($sql);
  $stmt->execute($data);

  $conn = null;

  $error = "Success! You may now login as $user";
  $_SESSION["error"] = $error;

  header('Location: login.php');

} catch(PDOException $e) {
  echo "failed: " . $e->getMessage();
  $conn = null;
}
