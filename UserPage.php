<?php
session_start();
if ($_SESSION['authenticate'] == session_id()) {?>
  <html>
  <head>
    <Title>Hello <?php echo $_SESSION['uname']; ?></title>
    <link rel="stylesheet" type="text/css" href="Rstyle.css">
    <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </head>
  <body class="bg">
    <Header>
      <h1>Encrypted message passing</h1>
    </header>
    <form action="UserPage.php"method="post">
    <div class="containerr">
    <div class="un">
      <p>
          <?php
            $username = $_SESSION['uname'];
            $db1 = mysqli_connect("localhost", "root", "", "msgpass");
            $sql_u = "SELECT * FROM $username";
            $res_u = mysqli_query($db1, $sql_u);
            if (isset($_POST['clr_data'])) {
              $clrudb = "DROP TABLE `msgpass`.`$username`;";
              mysqli_query($db1, $clrudb);?>
              <script>swal("Messages deleted!", "All messages deleted.", "success", {buttons: false, timer: 2100,});</script>
              <script>setTimeout(function(){
                window.location.href='Confirm.php';
              }, 2000);
              </script><?php
            }
          //session_start();
          $fromuser = $_SESSION['uname'];
          $fromuser_enc = base64_encode( $fromuser );
          $db = mysqli_connect("localhost", "root", "", "guasupp");

          if(!isset($_POST['touser'])){
            echo "Hello $username";
            if (mysqli_query($db1, $sql_u)) {
              $msgcount=mysqli_num_rows($res_u);
              echo ". You have $msgcount message(s)";

              $sql_getmsg = "SELECT message FROM msgpass.$username;";
              $sql_getmsgfrm = "SELECT msg_from FROM msgpass.$username;";
              $search_msg[]=mysqli_query($db, $sql_getmsg);
              $search_msg_sql=mysqli_query($db, $sql_getmsg);
              $search_msgfrm_sql=mysqli_query($db, $sql_getmsgfrm);
              $array0len=count($search_msg);
              $rowcount=mysqli_num_rows($search_msg_sql);
              //$_SESSION["rowcount"] = "$rowcount";
              for ($i=0; $i < $rowcount ; $i++) {
                $row = mysqli_fetch_array($search_msg_sql);
                $rowf = mysqli_fetch_array($search_msgfrm_sql);
                $msg[] = $row['message'];
                $msge = $msg[$i];
                $msg_dec[$i] = base64_decode( $msge );
                $msg_from[] = $rowf['msg_from'];?><br><?php
                $msg_from_enc[$i] = base64_decode( $msg_from[$i] );
                printf("Message from $msg_from_enc[$i]: $msg_dec[$i]");
              }
            }
            else {
              echo ". No messages received";
            }
            ?><br>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - <br>
            <label for="username" class="username" data-icon="e" >Select user to send message:  </label>
            <select name="touser"><?php
              $sql_search = "SELECT username FROM users;";
              $search_res[]=mysqli_query($db, $sql_search);
              $search_res_sql=mysqli_query($db, $sql_search);
              $array0len=count($search_res);
              $rowcount=mysqli_num_rows($search_res_sql);
              for ($i=0; $i < $rowcount; $i++) {
                $row = mysqli_fetch_array($search_res_sql);
                $wr[$i] = $row['username'];?>
                <option value="<?php printf("$wr[$i]"); ?>"><?php printf("$wr[$i]"); ?></option>
                <?php printf("$wr[$i]");
              }?>
            </select><br>
            <input type="checkbox" name="clr_data" value="clr"> Clear all messages<br>
            <?php
            }
          else {
            $touser = $_POST['touser'];
            $_SESSION['touser'] = $touser;
            $db1 = mysqli_connect("localhost", "root", "", "msgpass");
            echo "Message to: $touser";
            $createudb = "CREATE TABLE IF NOT EXISTS `msgpass`.`$touser` (`message` VARCHAR(100), `msg_from` VARCHAR(100));";
            mysqli_query($db1, $createudb);
            ?>
            <p>
              <label for="Message" class="uname" data-icon="u">Enter message :</label><br>
              <input class="msgbx" name="message" required="required" autofocus="autofocus" placeholder="Enter message to be sent" />
            </p><?php
          }
          if (isset($_POST['message'])) {
            $db1 = mysqli_connect("localhost", "root", "", "msgpass");
            $message = $_POST['message'];
            $tousermsg = $_SESSION['touser'];
            $message_enc = base64_encode( $message );
            $msgdb = "INSERT INTO $tousermsg (message, msg_from)
              			  VALUES('$message_enc', '$fromuser_enc');";
            mysqli_query($db1, $msgdb);?>
            <script>swal("Message sent!", "Message encrypted and sent.", "success", {buttons: false, timer: 2000,});</script>
            <script>setTimeout(function(){
              window.location.href='Confirm.php';
            }, 2500);
            </script><?php
          }
          ?>
      </p>
      </div>
      <input class="button" type="submit" vlaue="submit" >
      <input class="button2" type="button" onclick="window.location.href = 'UserPage.php';" value="Back"/>
      <input class="button2" type="button" onclick="window.location.href = 'LoginPage.php';" value="Logout"/>
      </div>
    </form>
  </body>
  </html>

  <?php
}
?>
