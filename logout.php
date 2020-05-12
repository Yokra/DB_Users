<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="users.css">
    <title>LOGOUT</title>
   
    
</head>
<body>

<header>
      <img src="img/logo.png" alt="logo" />
      <nav>
        <ul>
          <li><a href="#">About</a></li>
          <li><a href="#">Courses</a></li>
          <li><a href="login.php">Login</a></li>
        </ul>
      </nav>
    </header>   
        <main>
        <div class="container-logout">
        <h1 class="first">You have been logged out.</h1>
        <h2 class="second">Click <a class="link" href="login.php">here</a> to login again</h2>
         <div class="line"></div>
         </div>
</main>  
    
</body>
</html>

<?php
session_start();
session_destroy();
//header('Location: login.php');
//echo 'You have been logged out';
exit();

?>