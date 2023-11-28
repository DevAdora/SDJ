<?php 
session_start();
require_once 'config/connect.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN || Straich De Jyal</title>
    <link rel="stylesheet" type="text/css" href="style/loginpage.css" />
    <link rel="stylesheet" type="text/css" href="style/main.css" />

    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&display=swap" rel="stylesheet">
    <link rel="icon" type="image/gif" href="../images/logo.svg">
</head>
<form class="form" method="post" action="loginprocess.php">
       <h1 class="form-title">Sign in</h1>
        <div class="input-container">
          <input type="email" placeholder="Enter Email" name="email" id="username" required autofocus>
          <span>
          </span>
      </div>
      <div class="input-container">
          <input type="password" placeholder="Enter password" name="password" id="password" required>
        </div>
         <button type="submit" class="submit" name="submit">
        Sign in
      </button>
      <p class="signup-link">
        No account?
        <a href="registration.php">Sign up</a>
      </p>
   </form>
</body>
</html>
