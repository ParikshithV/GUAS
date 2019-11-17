<?php
session_start();
if (isset($_SESSION['authenticate'])) {?>
  <html>
  <head>
    <Title>Admin Page</title>
      <link rel="stylesheet" type="text/css" href="Rstyle.css">
      <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet">
      <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </head>
  <body class="bg">
    <Header>
      <h1>Admin Page</h1>
    </header>
    <form action="Admin.php"method="post">
    <div class="containerr">
    <div class="un">
      <p>
          <label for="username" class="uname" data-icon="u">Enter username for user removal:</label><br>
          <input class="txtbx" id="username" name="username" required="required" placeholder="Enter username of the user to be removed" />
      </p>
      <p>
          <input type="checkbox" name="update" value="dlt"> Remove User<br>
      </p>
      </div>
      <input class="button" type="submit" vlaue="submit" >
      <input class="button2" type="button" onclick="window.location.href = 'ForgotPassword.php';" value="Reset PassPhrase"/>
      <input class="button2" type="button" onclick="window.location.href = 'index.php';" value="Logout"/>
      <?php
      $db = mysqli_connect("localhost", "root", "", "guasupp");
      $sql_search = "SELECT username FROM users;";
      $search_res_sql=mysqli_query($db, $sql_search);
      $rowcount=mysqli_num_rows($search_res_sql);
      ?><br><br><u>Registered Users:</u><br>
      <?php
      $j=1;
        for ($i=0; $i < $rowcount; $i++) {
          $rowtwo = mysqli_fetch_array($search_res_sql);
          printf("$j: $rowtwo[0]");?><br>
          <?php $j++;
      }
      ?>

      </div>
    </form>
  </body>
  </html>

  <?php
  $db = mysqli_connect("localhost", "root", "", "guasupp");

  if (isset($_POST['username'])) {
    $cond=$_POST['update'];
    $username=$_POST['username'];
    // User Deletion
    if($cond=="dlt"){
      $username=$_POST['username'];
      $sql_u = "SELECT * FROM users WHERE username='$username'";
      $res_u = mysqli_query($db, $sql_u);
      if (mysqli_num_rows($res_u) > 0) {
        $sql_dlt="DELETE FROM `users` WHERE username = '$username'";
        mysqli_query($db, $sql_dlt);
        ?>
        <script>swal("User Removed!", " ", "success", {buttons: false, timer: 2000,});</script>
        <script>setTimeout(function(){
          window.location.href='Admin.php';
        }, 2500);
        </script><?php
      }
      else {
        echo '<script>swal("Error", "User not found", "warning");</script>';
      }
    }
  }
}
else {
  echo "Unauthorized Access";
}
?>
