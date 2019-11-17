<html>
<head>
  <Title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="Rstyle.css">
    <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body class="bg">
  <form action="LoginPage.php"method="post">
  <div class="container">
  <div class="un">
    <h1 style="margin: 1"> Login </h1>
<?php
session_start();

if(isset($_POST['refnum'])){
  $db = mysqli_connect("localhost", "root", "", "guasupp");
  $refin= mysqli_real_escape_string($db, $_POST['refnum']);
  $reff = $_SESSION["enc"];
  $uname=$_SESSION['uname'];
  $login_search = "SELECT login FROM users WHERE username = '$uname'";
  $loginattempt = mysqli_query($db, $login_search);
  $logno = mysqli_fetch_array($loginattempt);
  $lno = $logno[0];
if ($refin==$reff && $lno > -2){
  $uname=$_SESSION['uname'];
  $_SESSION['authenticate']=session_id();
  if ($uname == "Admin") {
    header("location:Admin.php");
  }
  elseif ($lno > -2){
    $uname=$_SESSION['uname'];
    $login = "UPDATE users
                SET login = '3'
                WHERE username = '$uname';";
    mysqli_query($db, $login);
    header("location:UserPage.php");
  }
}
else {
  $lnoo = $lno;
  if ($lno < 1) {
    $lnoo = 0;
  }
  echo "No. of login attempts left: $lnoo";?><br>
  <a href="ForgotPassword.php"><b>Pass-Phrase Reset?</b></a>
  <?php
  $login = "UPDATE users
              SET login = '$lno'
              WHERE username = '$uname';";
  mysqli_query($db, $login);
  echo '<script>swal("Login Failed!", "Incorrect reference numbers entered.", "warning");</script>';
  if ($lno < -1) {
    echo '<script>swal("", "Too many invalid attempts. Reset Pass-Phrase", "warning");</script>';
  }
  //unset($_SESSION['uname']);
}
}


  if(isset($_POST['rusername'])){
    $username=($_POST['rusername']);
    $_SESSION['uname']=$username;
    $username=$_SESSION['uname'];
    $db = mysqli_connect("localhost", "root", "", "guasupp");
    $sql_u = "SELECT * FROM users WHERE username='$username'";
    $res_u = mysqli_query($db, $sql_u);
    if (mysqli_num_rows($res_u) > 0) {
      $numbers = range(0, 1316);
      shuffle($numbers);
      $rand = array_slice($numbers, 0, 12);

      //select emoji from emojidb where emoji_id=1;
      for ($i=0; $i < 12 ; $i++) {
        $randemo = mysqli_query($db,"select emoji from emojidb where emoji_id=$rand[$i]");
        $emojisearch = mysqli_fetch_array($randemo);
        $emoji[] = $emojisearch['emoji'];
      }

      $uname=$_SESSION['uname'];
      $login_search = "SELECT login FROM users WHERE username = '$uname'";
      $loginattempt = mysqli_query($db, $login_search);
      $logno = mysqli_fetch_array($loginattempt);
      $lno = $logno[0];
      $lno--;
      $login = "UPDATE users
                  SET login = '$lno'
                  WHERE username = '$uname';";
      mysqli_query($db, $login);
      if ($lno < -1){
        ?><script>swal("", "Please reset Pass-Phrase to login.", "warning", {buttons: false, timer: 3000,});</script>
        <script>setTimeout(function(){
          window.location.href='ForgotPassword.php';
        }, 2500);
        </script><?php
      }

      $emosc1 = mysqli_query($db,"select emojichoice1 from users where username = '$username'");
      $emsearch1_enc = mysqli_fetch_row($emosc1);
      $emsearch1_dec = $emsearch1_enc[0];
      $emsearch1 = base64_decode($emsearch1_dec);

      $emosc2 = mysqli_query($db,"select emojichoice2 from users where username = '$username'");
      $emsearch2_enc = mysqli_fetch_row($emosc2);
      $emsearch2_dec = $emsearch2_enc[0];
      $emsearch2 = base64_decode($emsearch2_dec);

      $emosc3 = mysqli_query($db,"select emojichoice3 from users where username = '$username'");
      $emsearch3_enc = mysqli_fetch_row($emosc3);
      $emsearch3_dec = $emsearch3_enc[0];
      $emsearch3 = base64_decode($emsearch3_dec);

      $numbere = range(0, 11);
      shuffle($numbere);
      $rande = array_slice($numbere, 0, 11);
      $e1=$rande[3];
      $e2=$rande[6];
      $e3=$rande[8];

      //printf($rande[3]);
      $emoji[$e1] = "$emsearch1";
      $emoji[$e2] = "$emsearch2";
      $emoji[$e3] = "$emsearch3";
      $e1++;
      $e2++;
      $e3++;
      $reff="$e1"."$e2"."$e3";
      //echo "$reff";
      $refenc=$e1*$e2+$e3;
      $_SESSION["enc"] = "$reff";
      $e=1;
      $db = mysqli_connect("localhost", "root", "", "guasupp");
      $rusername = mysqli_real_escape_string($db, $_POST['rusername']);
      $login_search = "SELECT login FROM users WHERE username = '$uname'";
      $loginattempt = mysqli_query($db, $login_search);
      $logno = mysqli_fetch_array($loginattempt);
      $lno = $logno[0];
      $lno--;
      echo "Username: $rusername";
      ?><br><label for="passwordsignup" class="youpasswd" data-icon="p">Emoji Grid : </label><br>
      <div class="grid-container">
      <?php foreach ($emoji as $value):
        ?><div class="grid-item"><?php echo "$e: "; $e++ ?><i class="em <?php printf($value);?>"></i></div><?php
      endforeach; ?>
      </div>
      <label for="username" class="uname" data-icon="u">Enter emoji reference numbers without spaces:</label><br>
        <input class="txtbx" id="refnum" name="refnum" required="required" autofocus="autofocus" placeholder="Numbers under the emojis. Eg.: 548" />


  <?php
    }
    else {
      ?><p>
          <label for="username" class="uname" data-icon="u">Your username:</label><br>
          <input class="txtbx" id="rusername" name="rusername" required="required" autofocus="autofocus" placeholder="mysuperusername690" />
      </p><?php
      echo '<script>swal("", "Username not found", "error");</script>';
    }
  }
  else {
    ?><p>
        <label for="username" class="uname" data-icon="u">Your username:</label><br>
        <input class="txtbx" id="rusername" name="rusername" autofocus="autofocus" required="required" placeholder="mysuperusername690" />
    </p><?php
  }
?>

  <input class="button" type="submit" vlaue="submit" >
  <input class="button2" type="button" onclick="window.location.href = 'RegForm.php';" value="Register"/>
</div>
</form>
</body>
</html>
