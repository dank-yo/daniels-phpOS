<?php
session_name('current_session');
session_start();

$dbserv = "localhost";
$dbuser = "root";
$dbpass = "";

$UID = $_SESSION['uid'];
$user = $_SESSION['username'];
$timestamp = date('Y-m-d H:i:s');

$dbname = ("$user-$UID");

$message = $_POST['message_input'];
$friend_inbox=$_SESSION['friend_inbox'];

try {
  $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $data = ['recipientUID' => $_SESSION['friendUID'],
           'senderUID' => $UID,
           'message' => $message,
           'timestamp' => $timestamp,
          ];

  $sql = "insert into messages (recipientUID, senderUID, message, timestamp)
          values (:recipientUID, :senderUID, :message, :timestamp)";

  $stmt = $conn->prepare($sql);
  $stmt->execute($data);

  $conn = null;

  $conn = new PDO("mysql:host=$dbserv;dbname=$friend_inbox", $dbuser, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $data = ['recipientUID' => $_SESSION['friendUID'],
           'senderUID' => $UID,
           'message' => $message,
           'timestamp' => $timestamp,
          ];

  $sql = "insert into messages (recipientUID, senderUID, message, timestamp)
          values (:recipientUID, :senderUID, :message, :timestamp)";

  $stmt = $conn->prepare($sql);
  $stmt->execute($data);

  $conn = null;

  header("Location: messages.php?inboxID=".$_SESSION['friendUID']."&inboxUSER=".$_SESSION['friendUSERNAME']);

}catch(PDOException $e) {
  echo "failed: " . $e->getMessage();
  if($e->getCode()=="42S02"){
    $error = '[FATAL ERROR!]: Unable to connect to user inbox.';
    $_SESSION['error'] = $error;
  }
  header("Location: messages.php");
}

?>
