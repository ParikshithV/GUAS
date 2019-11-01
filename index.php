<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>About GUAS</title>
    <link rel="stylesheet" href="index.css">
    <link href="https://fonts.googleapis.com/css?family=Varela+Round&display=swap" rel="stylesheet">
    <div class="menu-bar">
      <label class="abt">Graphical User Authentication Interface</label>
    </div>
  </head>
  <body class="bg" style="padding-top: 70px">
    <center>
    <h2>About The Project</h2>
    <p style="width: 55%">
      This project is made to demonstrate a unique approach to user authentication
      which involves the use of graphical representations of common words in the
      form of emojis (emoticons). Using the same authentication method, user authentication
      for a secure message passing interface is demonstrated.
    </center>
    </p>

    <center style="padding-top: 2%">
      <h3>Components of the project</h3>
    <div class="box">
      <h4>Registration Page</h4>
      <p style="text-align: left">
        Similar to other online registration forms, a username, Email ID, and a three word PassPhrase
        needs to be entered, which is then validated and the user is asked to select emojis referring to the
        words entered for the PassPhrase. After the entered data is validated, it is encrypted
        and stored.
      </p>
      <button class="redb" onclick="window.location.href = 'RegForm.php';">Go to Registration Page</button>
    </div>
    <div class="box">
      <h4>Login Page</h4>
      <p style="text-align: left">
        In this page after the username is entered and checked if it exists in the database, the user is shown
        a mixed set of random emojis along with the emojis choosen during registration. The user needs to enter
        the reference numbers displayed next to the user choosen emojis in the right order. After the entered
        number is checked, the user is given access to the message passing interface.
      </p>
      <button class="redb" onclick="window.location.href = 'LoginPage.php';">Go to Login Page</button>
    </div>
    <div class="box">
      <h4>Message Passing Interface</h4>
      <p style="text-align: left">
        This interface facilitates the users to send end-to-end encrypted messages to any user who has been
        regisered. Any data stored about the messages or the sender is stored in an encrypted form and it is
        decrypted before displaying the same to the user.
      </p>
      <button class="redb" onclick="window.location.href = 'LoginPage.php';">Message Passing Interface</button>
    </div>
    </center>
    </body>
</html>
