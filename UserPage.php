<?php
session_start();
if (isset($_SESSION['authenticate'])) {?>
  <html>
  <head>
    <Title>Hello <?php echo $_SESSION['uname']; ?></title>
      <link rel="stylesheet" type="text/css" href="Rstyle.css">
  </head>
  <body>
    <Header><br><br>
      <h1>Encrypted message passing</</h1>
    </header>
    <form action="UserPage.php"method="post">
    <div class="container">
    <div class="un">
      <p>
          <?php
            $username = $_SESSION['uname'];
            $db1 = mysqli_connect("localhost", "root", "", "msgpass");
            $sql_u = "SELECT * FROM $username";
            $res_u = mysqli_query($db1, $sql_u);
            if (isset($_POST['clr_data'])) {
              $clrudb = "DROP TABLE `msgpass`.`$username`;";
              mysqli_query($db1, $clrudb);
              header("location:Confirm.php");
            }
          //session_start();
          $fromuser = $_SESSION['uname'];
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
                $msg_from[] = $rowf['msg_from'];?><br><?php
                printf("Message from $msg_from[$i]: $msg[$i]");
              }
            }
            else {
              echo ". No messages recived";
            }
            ?><br>- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - <br>
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
                <?php printf("$wr[$i]"); ?>
                <?php
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
              <input class="msgbx" name="message" required="required" placeholder="Enter message to be sent" />
            </p><?php
          }
          if (isset($_POST['message'])) {
            $db1 = mysqli_connect("localhost", "root", "", "msgpass");
            $message = $_POST['message'];
            $tousermsg = $_SESSION['touser'];
            $msgdb = "INSERT INTO $tousermsg (message, msg_from)
              			  VALUES('$message', '$fromuser');";
            mysqli_query($db1, $msgdb);
            header("location:Confirm.php");
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
