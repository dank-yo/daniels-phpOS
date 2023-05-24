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

$command_list = array('$help','$sql','$php');

$terminal_input= $_POST['terminal_input'];

class terminal_actions{

  function startsWith($haystack, $needle)
  {
      return strpos($haystack, $needle) === 0;
  }

  function endsWith($haystack, $needle){
      return strrpos($haystack, $needle) + strlen($needle) === strlen($haystack);
  }

  function printLine($input, $array){
    for($i = 0; $i<count($array); $i++){
      if(startsWith($input, $array[$i]))
      {

      }
      $string = "<tr><td>" . $input . "</td></tr>";
    }
    return "$string";
  }
}

$action = new terminal_actions();
echo($action->printLine($terminal_input, $command_list));

//header("Location: terminal.php");
?>
