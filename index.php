<?php
session_start();
include("DBConnection.php");
include("links.php");

if(isset($_GET["userId"]))
{
  $_SESSION["userId"]= $_GET["userId"];
  header("Location: chatbox.php");
}
 ?>


<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h4>Выберите учетную запись</h4>
    </div>
    <div class="modal-body">
      <ol>

      <?php
      $users= mysqli_query($connect, "SELECT * FROM users")
      or die("Нет подключения к бд".mysql_error());
      while($user= mysqli_fetch_assoc($users))
      {
        echo '<li>
        <a href="index.php?userId='.$user["id"].'">'.$user["User"].'</a>
        </li>


        ';
      }

       ?>
     </ol>
     <a href="registerUser.php" style="float:right;">Созать новую учетную запись</a>
    </div>
  </div>
</div>
</body>
</html>
