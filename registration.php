<?php 
session_start();
require_once 'config/connect.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="style/registration.css" />
    <link rel="stylesheet" type="text/css" href="style/main.css" />

    <link
      href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=EB+Garamond&display=swap" rel="stylesheet">
    <link rel="icon" type="image/gif" href="images/straich de jyal.svg">
</head>
<body>
<form class="form" method="POST" action="registerprocess.php">
    <h1>Register </h1>
        <div class="flex">
        <label>
            <input class="input" type="text" name="firstname" placeholder="Firstname" required="" autocomplete="off">
        </label>
        <label>
            <input class="input" type="text"name="lastname" placeholder="Lastname" required=""  autocomplete="off">
        </label>
    </div>           
    <label>
        <input class="input" type="text" name="address" placeholder= "Address" required=""  autocomplete="off">
    </label>    
    <label>
        <input class="input" type="email" name="email" placeholder="Email" required="" autocomplete="off">
    </label>
    <label>
        <input class="input" type="password" name="password" placeholder="Password" required="" autocomplete="off">
    </label>
    <button class="submit" name="register" value="register">Sign up</button>
    <p class="signup-link">
        Have an Account?
        <a href="login.php">Sign in</a>
      </p>
</form>
</body>
</html>