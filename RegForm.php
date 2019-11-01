<html>
<head>
  <Title>Registration Page</title>
  <link rel="stylesheet" type="text/css" href="Rstyle.css">
  <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body class="bg">
  <form action="RegForm.php"method="post">
  <div class="containerr">
  <div class="un">
    <h1 style="margin: 1"> Sign up </h1>
    <p>
        <label for="username" class="uname" data-icon="u">Your username:</label><br>
        <input class="txtbx" id="username" name="username" required="required" placeholder="mysuperusername690" />
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
        $passphrase_enc = base64_encode( $passphrase );

        $username = mysqli_real_escape_string($db, $_POST['username']);
        $emailid = mysqli_real_escape_string($db, $_POST['emailid']);
        $emailid_enc = base64_encode( $emailid );
        $sql_u = "SELECT * FROM users WHERE username='$username'";
        $res_u = mysqli_query($db, $sql_u);
        $userdb = "INSERT INTO users (username, emailid, passphrase, login)
          			  VALUES('$username', '$emailid_enc', '$passphrase_enc', '3')";

        $createudb = "CREATE TABLE IF NOT EXISTS `msgpass`.`$username` (`message` VARCHAR(100), (`msg_from` VARCHAR(100)));";

        $une = "";
        $worderror="";

          if (mysqli_num_rows($res_u) > 0) {
            $une = "Username not available! Please enter different username.";
            echo '<script>swal("", "Username not available", "error");</script>';
            //echo $une;
          }
          elseif ($word0==$word1||$word0==$word2||$word1==$word2){
            echo '<script>swal("Error", "Two or more similar words found in the passphrase. please enter unique words", "info");</script>';
            //$worderror="Two or more similar words found in the passphrase. please enter unique words";
            echo $worderror;
          }
          else{
            $name_error = "Username Available";
            $createdb = "CREATE TABLE IF NOT EXISTS `guasupp`.`users` (`username` VARCHAR(100) NOT NULL,`emailid` VARCHAR(100) NOT NULL,`passphrase` VARCHAR(100) NOT NULL,
                          `emojichoice1` VARCHAR(100), `emojichoice2` VARCHAR(100), `emojichoice3` VARCHAR(100), `login` INT(10), PRIMARY KEY (`username`),UNIQUE INDEX `username_UNIQUE` (`username` ASC));";
            mysqli_query($db, $createdb);

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
              mysqli_query($db, $createudb);
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
