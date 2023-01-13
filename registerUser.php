<?php
session_start();
include("DBConnection.php");
include("links.php");

if(isset($_POST["uName"]))
{
  $sql="INSERT INTO users (User) VALUES('".$_POST["uName"]."')";

  if($connect->query($sql))
  header('Location: index.php');
  else
  echo "Ошибка,поробйте еще раз";
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
         <h4>зарегистрируйте свой логин</h4>
       </div>
       <div class="modal-body">
        <form action="registerUser.php" method="POST">
          <p>Name</p>
          <input type="text" name="uName" id="uName"  class="form-conrol" autocomplete="off"/>
          <br>
            <input type="submit" name="submit"   class="btn btn-primary" style="float:right;" value="OK"/>
        </form>
       </div>
     </div>
   </div>
   </body

 </body>
 </html>
