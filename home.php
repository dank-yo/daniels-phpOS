<?php
session_name('current_session');
session_start();

$UID = $_SESSION['uid'];
$user = $_SESSION['username'];
$timestamp = $_SESSION['timestamp'];

if(empty($user))
{
  $error = "Error: Unable to fetch user. Try again!";
  $_SESSION["error"] = $error;
  header("Location:login.php");
}

?>

<!doctype html>
<html>
<head>
  <title>WebOS</title>
  <link rel="stylesheet" type="text/css" href="assets/styles/style_default.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta charset='utf-8'>
  <!-- Live Date/Time Script: Credits to Original Author-->
  <script>
    <!--Time Script *credits to not me*-->
    function startTime() {
      var today = new Date();
      var h = today.getHours();
      var m = today.getMinutes();
      var s = today.getSeconds();
      m = checkTime(m);
      s = checkTime(s);
      document.getElementById('time').innerHTML = h + ":" + m + ":" + s;
      var t = setTimeout(startTime, 500);
    }
    function checkTime(i) {
      if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
      return i;
    }
  </script>
</head>

<header>
  <div class='navigator'>
    <div class='navigator-logo'>
      <input type="button" class='navigator-button-icon' value="◯" onclick="toggleDropdown()"/>
      <div id="dropdown" class='account-pane'>
        <table>
          <tr>
            <th>
              <p>Info</p>
            </th>
          </tr>
          <tr>
        </table>
        <table>
          <tr>
            <td style='width: 62px;'>
              <img src='assets/img/icons/default_avatar.png' width=60px></img>
            </td>
            <td>
              <?php
                echo "UID: $UID";
                echo "<br>";
                echo "User: $user";
                echo "<br>";
                echo "Created: $timestamp";
               ?>
            </td>
          </tr>
          <tr>
            <td>
              <input type="button" class='login-button' value="࿊" onclick="window.location.href='session_end.php'"/>
            </td>
          </tr>
        </table>
      </div>
      <script>
      function toggleDropdown(){
        var panel = document.getElementById("dropdown");
        if (panel.style.display === "none") {
          panel.style.display = "block";
        } else {
          panel.style.display = "none";
        }
      }
      </script>
    </div>
    <div class='navigator-text' id='time'></div>
  </div>
</header>

<body onload="startTime()">
  <div class='container-body'>
    <div class='container-dock'>
      <div id='dock-container' class='dock'>
        <ul>
          <li><a class='dock-button' href='pages/terminal.php' target='navigator'><img src="assets/img/icons/terminal_icon.png" alt="Terminal" width=90%></a></li>
          <li><a class='dock-button' href='pages/file-explorer.php' target='navigator'><img src="assets/img/icons/folder_icon.png" alt="Folder" width = 90%></a></li>
          <li><a class='dock-button' href='pages/messages.php' target='navigator'><img src="assets/img/icons/messages_icon.png" alt="Folder" width = 90%></a></li>
          <li><a class='dock-button' href='pages/browser.php' target='navigator'><img src="assets/img/icons/browser_icon.png" alt="Browser" width = 90%></a></li>
          <li><a class='dock-button' href='pages/file_explorer.php' target='navigator'><img src="assets/img/icons/editor_icon.png" alt="Editor" width = 90%></a></li>
          <li><a class='dock-button' href='pages/file_explorer.php' target='navigator'><img src="assets/img/icons/preferences_icon.png" alt="Preferences" width = 90%></a></li>
        </ui>
      </div>
    </div>
    <div class='main-body'>
      <!--window drag script-->
      <div id='window-pane'>
        <div id='window-pane-head'>
          <p id='title' style='margin:0px; padding: 0px;'>Navigator</p>
        </div>
        <div style="overflow: hidden; width: 100%; height: 95.5%; margin: 0px; padding: 0px;">
          <iframe style="overflow: hidden;" width=100% height=100% src="pages/welcome.php" frameborder="0" name="navigator"></iframe></div>
      </div>
    </div>
  </div>

  <!--Drag DIV Script-->
  <script>

    //Make the DIV element draggagle:
    dragElement(document.getElementById("window-pane"));

    function dragElement(elmnt) {
      var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
      if (document.getElementById(elmnt.id + "-head")) {
        /* if present, the header is where you move the DIV from:*/
        document.getElementById(elmnt.id + "-head").onmousedown = dragMouseDown;
      } else {
        /* otherwise, move the DIV from anywhere inside the DIV:*/
        elmnt.onmousedown = dragMouseDown;
      }

      function dragMouseDown(e) {
        e = e || window.event;
        e.preventDefault();
        // get the mouse cursor position at startup:
        pos3 = e.clientX;
        pos4 = e.clientY;
        document.onmouseup = closeDragElement;
        // call a function whenever the cursor moves:
        document.onmousemove = elementDrag;
      }

      function elementDrag(e) {
        e = e || window.event;
        e.preventDefault();
        // calculate the new cursor position:
        pos1 = pos3 - e.clientX;
        pos2 = pos4 - e.clientY;
        pos3 = e.clientX;
        pos4 = e.clientY;
        // set the element's new position:
        elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
        elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
      }

      function closeDragElement() {
        /* stop moving when mouse button is released:*/
        document.onmouseup = null;
        document.onmousemove = null;
      }
    }
  </script>
</body>
</html>
<?php echo session_id();  ?>
