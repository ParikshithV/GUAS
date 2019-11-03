<html>
<head>
  <Title>Forgot PassPhrase</title>
    <link rel="stylesheet" type="text/css" href="Rstyle.css">
    <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body class="bg">
  <Header>
    <h1> PassPhrase Reset Page</h1>
  </header>
  <form action="ForgotPassword.php"method="post">
  <div class="container">
  <div class="un">
    <p>
        <label for="username" class="uname" data-icon="u">Your username:</label><br>
        <input class="txtbx" id="username" name="username" required="required" autofocus="autofocus" placeholder="mysuperusername690" />
    </p>
    <p>
        <label for="emailsignup" class="youmail" data-icon="e" >Your email:</label><br>
        <input class="txtbx" id="emailid" name="emailid" required="required" type="email" placeholder="mysupermail@mail.com"/>
    </p>
    <p>
        <label for="passwordsignup" class="youpasswd" data-icon="p">Enter three words for passphrase : </label><br>
        <input class="txtbx" id="passphrase" name="word0" required="required" placeholder="eg. boy"/>
        <input class="txtbx" id="passphrase" name="word1" required="required" placeholder="eg. girl"/>
        <input class="txtbx" id="passphrase" name="word2" required="required" placeholder="eg. computer"/>
    </p>
  </div>

<?php
      session_start();
      $db = mysqli_connect("localhost", "root", "", "guasupp");

      if(!empty($_POST['username'])){

        $word0 = ($_POST['word0']);
        $word1 = ($_POST['word1']);
        $word2 = ($_POST['word2']);

        $word0 = trim($word0);
        $word1 = trim($word1);
        $word2 = trim($word2);
        $passphrase = $word0." ".$word1." ".$word2;

        $username = mysqli_real_escape_string($db, $_POST['username']);
        $emailin = mysqli_real_escape_string($db, $_POST['emailid']);
        $sql_u = "SELECT * FROM users WHERE username='$username'";
        $res_u = mysqli_query($db, $sql_u);
        $passphrase_enc = base64_encode( $passphrase );
        $userdb = "UPDATE users
                    SET passphrase = '$passphrase_enc', login = '3' WHERE username = '$username';";
        $email = mysqli_query($db,"select emailid from users where username = '$username'");
        $emailid_enc = mysqli_fetch_row($email);
        $emailid = base64_decode($emailid_enc[0]);
        $emaildb=$emailid;

        $une = "";
        $worderror="";

          if (mysqli_num_rows($res_u) < 1) {
            echo '<script>swal("", "Username not found", "error");</script>';
            //echo " $une";
          }
          elseif ($emaildb!=$emailin) {
            echo '<script>swal("", "Incorrect email address", "error");</script>';
          }
          elseif ($word0==$word1||$word0==$word2||$word1==$word2){
            echo '<script>swal("Error", "Two or more similar words found in passphrase. please enter unique words.", "info");</script>';
          }
          else{
              $db = mysqli_connect("localhost", "root", "", "guasupp");

              $sql_search = "SELECT * FROM emojidb WHERE emoji LIKE '%$word0%'";
              $search_res_sql=mysqli_query($db, $sql_search);
              $rowcountw1=mysqli_num_rows($search_res_sql);

              $sql_search = "SELECT * FROM emojidb WHERE emoji LIKE '%$word1%'";
              $search_res_sql=mysqli_query($db, $sql_search);
              $rowcountw2=mysqli_num_rows($search_res_sql);

              $sql_search = "SELECT * FROM emojidb WHERE emoji LIKE '%$word2%'";
              $search_res_sql=mysqli_query($db, $sql_search);
              $rowcountw3=mysqli_num_rows($search_res_sql);

              $emojierror1="";
              $emojierror2="";
              $emojierror3="";

              echo "Entered PassPhrase: $word0 $word1 $word2";
              echo "<br>";

              if($rowcountw1<1){
                $emojierror1="No emoji choices for $word0. Please enter a different word";
                echo "$emojierror1";
                echo "<br>";
              }
              if($rowcountw2<1){
                $emojierror2="No emoji choices for $word1. Please enter a different word";
                echo "$emojierror2";
                echo "<br>";
              }
              if($rowcountw3<1){
                $emojierror3="No emoji choices for $word2. Please enter a different word";
                echo "$emojierror3";
                echo "<br>";
              }

              if (!empty($emojierror1||$emojierror2||$emojierror3)) {
                echo '<script>swal("Error", "Please check alert messages above the word suggestions", "info");</script>';
              }


            if(empty($_POST[$une])&&(empty($_POST[$worderror]))&&(empty($emojierror1))&&(empty($emojierror2))&&(empty($emojierror3))) {
              //header('Location:regepage.php');
              $_SESSION["username"] = "$username";
              $_SESSION["word0"] = "$word0";
              $_SESSION["word1"] = "$word1";
              $_SESSION["word2"] = "$word2";
              mysqli_query($db, $userdb);
              header("Location: emojiInput.php?");
              //exit();
            }
          }
        }
    ?>
    <p style="font-size:15px;line-height:2;">
      Word Suggestions:<br>Airplane, Camera, Star, Sun, Moon, Book, Heart, Boy, Girl, Kiss, Pizza,
       Bus, Computer, Doctor, Farmer, Scientist, Fire, Rabbit, Monkey, Dog...
    </p>
	    <input class="button" type="submit" vlaue="submit" >
    <input class="button2" type="button" onclick="window.location.href = 'loginpage.php';" value="Login"/>
    </div>
    </div>
  </form>
</body>
</html>
