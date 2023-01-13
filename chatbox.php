<?php
session_start();
include("DBConnection.php");
include("links.php");

$users =mysqli_query($connect, "SELECT * FROM  users WHERE id = '".$_SESSION["userId"]."'")
    or die("Ошибка подключения к базе данных ".mysql_error());
    $user = mysqli_fetch_assoc($users);
 ?>

 <!DOCTYPE html>
 <html>
 <head>
   <title></title>
 </head>
 <body>
   <div class="container-fluid">
     <div class="row">
       <div class="col-md-4">
         <p>Привет <?php echo $user["User"]; ?> </p>
         <input type="text" id="fromUser" value=<?php echo $user["id"]; ?> hidden/>
         <p>Выберите собеседника</p>
         <ul>
           <?php
           $msgs =mysqli_query($connect, "SELECT * FROM  users ")
               or die("Ошибка подключения к базе данных ".mysql_error());
              while($msg = mysqli_fetch_assoc($msgs))
              {
                if($msg["User"]==$user["User"]){
                echo '<li><a href="?toUser='.$msg["id"].'" >Избранное</a></li>';}
                else{
                echo '<li><a href="?toUser='.$msg["id"].'">'.$msg["User"].'</a></li>';}
              }
            ?>
         </ul>
         <a href="index.php"><-----Назад</a>
       </div>
       <div class="col-md-4">

         <div class="modal-dialog">
           <div class="modal-content">
             <div class="modal-header">
               <h4>
                 <?php
                 if(isset($_GET["toUser"]))
                 {
                   $userName =mysqli_query($connect, "SELECT * FROM  users WHERE id ='".$_GET["toUser"]."' ")
                       or die("Ошибка подключения к базе данных ".mysql_error());
                      $uName = mysqli_fetch_assoc($userName);
                        echo '<input type="text" value='.$_GET["toUser"].' id="toUser" hidden/>';
                        if( $uName["User"] == $user["User"] ){
                            echo "Избранное";
                        }else{

                        echo $uName["User"];}
                 }
                 else {
                   $userName =mysqli_query($connect, "SELECT * FROM  users  ")
                       or die("Ошибка подключения к базе данных ".mysql_error());
                      $uName = mysqli_fetch_assoc($userName);
                      $_SESSION["toUser"]=$uName["id"];
                        echo '<input type="text" value='.$_SESSION["toUser"].' id="toUser" hidden/>';
                        echo "Избранное";
                 }


               ?>
             </h4>
             </div>
             <div class="modal-body" id="msgbody" style="height:400px; overflow-y:scroll; overflow-x:hidden;">
               <?php
               if(isset($_GET["toUser"]))
               $chats =mysqli_query($connect, "SELECT * FROM  messages WHERE (FromUser = '".$_SESSION["userId"]."' AND
               ToUser= '".$_GET["toUser"]."') OR (FromUser = '".$_GET["toUser"]."' AND
               ToUser= '".$_SESSION["userId"]."') ")
                   or die("Ошибка подключения к базе данных ".mysql_error());

                  else
                  $chats =mysqli_query($connect, "SELECT * FROM  messages WHERE (FromUser = '".$_SESSION["userId"]."' AND
                  ToUser= '".$_SESSION["toUser"]."') OR (FromUser = '".$_SESSION["toUser"]."' AND
                  ToUser= '".$_SESSION["userId"]."') ")
                      or die("Ошибка подключения к базе данных ".mysql_error());


                     while($chat = mysqli_fetch_assoc($chats))
                     {
                       if($chat["FromUser"] == $_SESSION["userId"])
                       echo "<div style='text-align:right;'>
                        <p style='background-color:lightblue; word-wrap:break-word; display:inline-block; padding:5px;
                        border-radius:10px; max width:70%;'>
                            ".$chat["Message"]."
                        </p>
                        </div>";
                        else
                        echo "<div style='text-align:left;'>
                         <p style='background-color:yellow; word-wrap:break-word; display:inline-block; padding:5px;
                         border-radius:10px; max width:70%;'>
                             ".$chat["Message"]."
                         </p>
                         </div>";
                     }
                ?>


             </div>
             <div class="modal-footer">
               <textarea id="message" class="form-control" style="height:70px;"></textarea>
               <button id="send" class="btn btn-primary" style="height:70px;">Oтправить сообщение</button>
             </div>
           </div>
         </div>

       </div>
       <div class="col-md-4">
       </div>

     </div>

   </div>

 </body>
 <script type="text/javascript">
  $(document).ready(function(){

    $("#send").on("click",function(){
      $.ajax({
        url:"InsertNessage.php",
        method:"POST",
        data:{
          fromUser: $("#fromUser").val(),
          toUser: $("#toUser").val(),
          message: $("#message").val()
        },
        dataType:"text",
        success:function(data){
          $("#message").val("");
        }
      });


    });
    setInterval(function(){
      $.ajax({

        url:"realTimeChat.php",
        method:"POST",
        data:{
          fromUser:$("#fromUser").val(),
          toUser:$("#toUser").val()

        },
        dataType:"text",
        success:function(data){
          $("#msgbody").html(data);
        }

      });
    },70);




  });
  </script>
 </html>
