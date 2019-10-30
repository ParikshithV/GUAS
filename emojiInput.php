<?php
session_start();
if (isset($_SESSION['username'])) {
    function username(){
      $username = $_SESSION["username"];
      echo $username;
    }

    function passphrase(){
      $word0 = $_SESSION["word0"];
      $word1 = $_SESSION["word1"];
      $word2 = $_SESSION["word2"];
      echo "$word0 $word1 $word2";
    }


  ?>


  <html>
  <head>
    <Title>Emoji Input</title>
      <link rel="stylesheet" type="text/css" href="Rstyle.css">
      <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </head>
  <body class="bg">
    <form action="emojiInput.php"method="post">
      <div class="container">
        <div>
        <h1>Emoji selection</h1>
        <label for="username">Username: </label>
        <?php username(); ?>
        </div>
        <div>
        <label for="passphrase">words in the PassPhrase: </label>
        <?php passphrase(); ?><br>
        </div>
        <div>
        <label for="instruction">Select the reference emojis for each word:</label><br>
        <div id="leftbox">
            <?php
            function displayw1(){
              $db = mysqli_connect("localhost", "root", "", "guasupp");
              $word0 = $_SESSION["word0"];
              echo "Word 1: $word0";?><br><?php
              $sql_search = "SELECT * FROM emojidb WHERE emoji LIKE '%$word0%'";
              $search_res[]=mysqli_query($db, $sql_search);
              $search_res_sql=mysqli_query($db, $sql_search);
              $array0len=count($search_res);
              $rowcountw1=mysqli_num_rows($search_res_sql);
              $_SESSION["rowcountw1"] = "$rowcountw1";
                for ($i=0; $i < $rowcountw1 ; $i++) {
                  $row = mysqli_fetch_array($search_res_sql);
                  $wr0[] = $row['emoji'];
                  ?>
                  <input type="radio" name="emojichoice1" value="<?php printf($wr0[$i]);?>"> <i class="em <?php printf($wr0[$i]);?>"></i><br>
                  <?php
                }
            }
            displayw1();
            ?>
        </div>

        <div id="middlebox">
            <?php
            function displayw2(){
              $db = mysqli_connect("localhost", "root", "", "guasupp");
              $word1 = $_SESSION["word1"];
              echo "word 2: $word1";?><br><?php
              $sql_search = "SELECT * FROM emojidb WHERE emoji LIKE '%$word1%'";
              $search_res[]=mysqli_query($db, $sql_search);
              $search_res_sql=mysqli_query($db, $sql_search);
              $array0len=count($search_res);
              $rowcountw2=mysqli_num_rows($search_res_sql);
              $_SESSION["rowcountw2"] = "$rowcountw2";
                for ($i=0; $i < $rowcountw2 ; $i++) {
                  $row = mysqli_fetch_array($search_res_sql);
                  $wr0[] = $row['emoji'];
                  ?>
                  <input type="radio" name="emojichoice2" value="<?php printf($wr0[$i]);?>"> <i class="em <?php printf($wr0[$i]);?>"></i><br>
                  <?php
                }
            }
            displayw2();
            ?>
        </div>

        <div id="rightbox">
            <?php
            function displayw3(){
              $db = mysqli_connect("localhost", "root", "", "guasupp");
              $word2 = $_SESSION["word2"];
              echo "word 3: $word2";?><br><?php
              $sql_search = "SELECT * FROM emojidb WHERE emoji LIKE '%$word2%'";
              $search_res[]=mysqli_query($db, $sql_search);
              $search_res_sql=mysqli_query($db, $sql_search);
              $array0len=count($search_res);
              $rowcountw3=mysqli_num_rows($search_res_sql);
              $_SESSION["rowcountw3"] = "$rowcountw3";
                for ($i=0; $i < $rowcountw3 ; $i++) {
                  $row = mysqli_fetch_array($search_res_sql);
                  $wr0[] = $row['emoji'];
                  ?>
                  <input type="radio" name="emojichoice3" value="<?php printf($wr0[$i]);?>"> <i class="em <?php printf($wr0[$i]);?>"></i><br>
                  <?php
                }
            }
            displayw3();
            ?>
        </div>
      </div>
      <input class="button" type="submit" vlaue="submit" >
      <div id="bottomerror">
      <?php
      if(!empty($_POST['emojichoice1'])&&($_POST['emojichoice2'])&&($_POST['emojichoice3'])){
        $db = mysqli_connect("localhost", "root", "", "guasupp");
        $emojichoice1 = mysqli_real_escape_string($db, $_POST['emojichoice1']);
        $emojichoice2 = mysqli_real_escape_string($db, $_POST['emojichoice2']);
        $emojichoice3 = mysqli_real_escape_string($db, $_POST['emojichoice3']);

        if($emojichoice1==$emojichoice2||$emojichoice1==$emojichoice3||$emojichoice2==$emojichoice3){
          echo '<script>swal("", "Two or more similar emojis selected", "error");</script>';
        }
        else {
          $username = $_SESSION["username"];
          $userdb = "UPDATE users
                      SET emojichoice1 = '$emojichoice1', emojichoice2 = '$emojichoice2', emojichoice3 = '$emojichoice3'
                      WHERE username = '$username';";
          mysqli_query($db, $userdb);
          session_destroy();?>
          <script>swal("Registered", "Registration successful", "success", {buttons: false, timer: 1200,});</script>
          <script>setTimeout(function(){
            window.location.href='LoginPage.php';
          }, 1500);
          </script>
          <input class="button2" type="button" onclick="window.location.href = 'loginpage.php';" value="Login"/><?php
        }
      }
      ?>
    </div>
      </div>
    </form>
  </body>
  </html>
<?php } ?>
