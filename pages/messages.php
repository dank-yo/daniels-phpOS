<?php
session_name('current_session');
session_start();

$dbserv = "localhost";
$dbuser = "root";
$dbpass = "";

$UID = $_SESSION['uid'];
$user = $_SESSION['username'];
$timestamp = $_SESSION['timestamp'];

$dbname = ("$user-$UID");

try {
  $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  $sql_uid = "SELECT UID
          FROM friends
          ORDER BY username DESC";

          $getFriendUID = $conn->prepare($sql_uid);
          $getFriendUID->execute();
          $friendUID = $getFriendUID->fetchAll();

  $sql_username = "SELECT username
          FROM friends
          ORDER BY username DESC";

          $getFriendUsername = $conn->prepare($sql_username);
          $getFriendUsername->execute();
          $friend_username = $getFriendUsername->fetchAll();

  $conn = null;

}catch(PDOException $e) {
  echo "[FATAL ERROR]: " . $e->getMessage();
  echo "[CODE]: " . $e->getCode();
  if($e->getCode()=="42S02")
  {
    $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "create table friends(
            UID INT(6),
            username TEXT(50) NOT NULL
            )";

    $conn->exec($sql);
    $conn = null;
    header("Location: messages.php");
  }
}

?>

<!doctype html>
<html>
<head>
  <title>WebOS</title>
  <link rel="stylesheet" type="text/css" href="styles/messages-style-sheet.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset='utf-8'>
  <style>
    *{}

    body{
      margin:0px;
      padding:0px;
    }
    a:link {
      text-decoration: none;
      color: #ffffff;
    }
    a:link:hover{
      text-decoration: none;
      color: #808080;
    }

  </style>
</head>

<body style='overflow: hidden;'>
  <div class='friends_panel' style='display: inline-block; background-image: linear-gradient(#202020, #101010); width: 30%; height: 100vh;'>
    <div style='height: 8%;'>
      <table style='margin: 0px; padding: 0px; width: 100%; height: 15%;'>
        <tr class='row' id='head' style='margin: 0px; padding: 0px; width: 100%; height: 10%;'>
          <td style='margin: 0px; padding: 0px; width: 10%;'><h3 style='margin: 0px; padding: 12px 2px; '>Search:</h3></td>
          <td style='margin: 0px; padding: 0px; width: 100%; height: 50%;'><input style='width: 100%; height: 60%;' type='text'></td>
        </tr>
      </table>
    </div>
    <div class='friends-list' style='display: inline-block; overflow-x: hidden; overflow-y: scroll; width: 100%; height: 90%;'>
      <table>
        <?php
        if(!empty($friend_username)){
          for($i = 0; $i<count($friend_username); $i++){
            echo "<tr style='white-space:nowrap; height: 80px;'>";
            echo "<td class='avatar' style=' white-space:nowrap; width: 25px; height: 80px;'>
                    <img src='../assets/img/icons/default_avatar.png' width=60px></img>
                  </td>";
            echo "<td style='width: 100%; height: 60px;'> " . "<a href=messages.php?inboxID=".$friendUID[$i][0]."&inboxUSER=".$friend_username[$i][0] . ">" . $friend_username[$i][0] . "</td></tr></a>";
            //checks messages table in database, if it doesnt exists then creates new table
            if(!empty($_GET['inboxID'])){
              try{
                $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $inboxID = $_GET['inboxID'];
                $inboxUSER = $_GET['inboxUSER'];

                $_SESSION['friend_inbox'] = "$inboxUSER-$inboxID";
                $_SESSION['friendUID'] = "$inboxID";
                $_SESSION['friendUSERNAME'] = "$inboxUSER";

                $sql_inbox = "SELECT senderUID, recipientUID, message
                      FROM messages";

                $getMessages = $conn->prepare($sql_inbox);
                $getMessages->execute();
                $messages = $getMessages->fetchAll();

                $conn = null;
              }catch(PDOException $e){
                echo "[FATAL ERROR]: " . $e->getMessage();
                if($e->getCode()=="42S02")
                {
                  $conn = new PDO("mysql:host=$dbserv;dbname=$dbname", $dbuser, $dbpass);
                  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                  $sql = "create table messages(
                         recipientUID INT(6) NOT NULL ,
                         senderUID INT(6) NOT NULL ,
                         message TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
                         timestamp DATETIME NOT NULL
                         )";

                  $conn->exec($sql);
                  $conn = null;
                  header("Location: messages.php");
                }
              }
            }
          }
        }else{
          if(isset($_SESSION['error']))
          {
            $error = $_SESSION['error'];
            echo "<tr><td style='height: 100%; text-align: center; color: #ff0000'><h1>" . "$error" . "</h1></td></tr>";
          }else{
            echo "<tr><td style='height: 100%; text-align: center; color: #888888'><h1>Looks like you have no friends!</h1></td></tr>";
          }
        }
        ?>
      </table>
    </div>
  </div>
  <div style='margin-left: -3px; padding: 0px; background-image: linear-gradient(#181818, #080808); display: inline-block; vertical-align: top; width: 70%; height: 93vh'>
    <div class='messages' style='overflow-x: hidden; overflow-y: scroll; display: inline-block; width: 100%; height: 100%;'>
      <table style='width: 100%;'>
        <?php
        if(!empty($_SESSION['friend_inbox'])){
          if(!empty($messages)){
            for($i = 0; $i<count($messages); $i++){
              if($messages[$i][0]==$_SESSION['friendUID'] && $messages[$i][1]==$UID){
                echo "<tr>";
                echo "<td><div style='float: left; padding-left: 3px; padding-right: 3px; border-radius: 3px; background-color: #888888'><p>" . $messages[$i][2] . "</p></div></td>";
                echo "</tr>";
              }
              if($messages[$i][0]==$UID && $messages[$i][1]==$_SESSION['friendUID']){
                echo "<tr>";
                echo "<td><div style='float: right; padding-left: 3px; padding-right: 3px; border-radius: 3px; background-color: #00cccc'><p>" . $messages[$i][2] . "</p></div></td></tr>";
                echo "</tr>";
              }
            }
          }else{
            echo "<div style='margin:0px; padding: 0px; width: 100%; height: 100vh; text-align: center; verticle-align: middle;'><br><h1 style='color:#808080;'> You do not have any messages to display!</h1><div>";
          }
        }
        ?>
      </table>
    </div>
    <div style='background-color: #000000; margin: 0px; padding: 0px; width: 100%; height: 100%'>
      <form method = "post" action ="message_send.php">
        <input style='margin: 0px; padding: 2px 4px;' type='text' name='message_input' width=100% height=100%></input>
      </form>
    </div>
  </div>
</body>
</html>

<?php
  unset($_SESSION['error']);
?>
