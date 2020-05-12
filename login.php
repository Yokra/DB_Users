<?php
//Connect to the database
require_once("connection.php");

//global var
$errors = array();
$password = "";
$user_email = "";

//Validation
if (isset($_POST['login-btn'])){
  $user_email = $_POST['user_name'];
  $password = $_POST['password'];

  if(empty($user_email)){
    array_push($errors, "Email is required");
  }
  if (empty($password)){
    array_push($errors, "Password is required");
  }
  if(count($errors) == 0){
  $password = md5($password);//encript password before comparing 
  $sql = "SELECT * FROM Accounts WHERE user_email = '$user_email' AND password = '$password' LIMIT 1" ;
  $statement = $conn->prepare($sql);
  $statement->bind_param('ss', $user_email, $password);
  $statement->execute(); 
  $result = $statement->get_result();
  $user = $result->fetch_assoc();

  if(password_verify($password, $user['password'])){
    //login success
    $_SESSION['user_email'] = $user_email;
    //$_SESSION['user_email'] = $user['user_email'];
    //To start using sessions/cookies u must start the session
    session_start();
  }else{
    $errors['login_fail'] = "Wrong password or email adress";
  }
    //echo 'Success';
    header('Location: logout.php'); // Redirect and always exit after, that means that the browser will lead the user to that page and then will exit. 
    exit();
}
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="users.css" />
    <title>LOG IN</title>
  </head>
  <body>
    <header>
      <img src="img/logo.png" alt="logo" />
      <nav>
        <ul>
          <li><a href="#">About</a></li>
          <li><a href="#">Courses</a></li>
          <li><a href="signup.php">Create account</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <div class="container-log-in">
        <h1>LOG IN</h1>
        <form class="form-log-in" action="login.php" method="POST">
          <input type="text" placeholder="Email" name="user_email" value="<?php echo $user_email; ?>"/>
          <input type="password" placeholder="Password" name="password" value="<?php echo $password; ?>" />
        </form>
        <button name="login-btn" class="log-in" type="submit">LOG IN</button>
        <p class="paragraph">
          You don't have an account yet?
          <a style="color: blue;" href="./signup.php">Sign up!</a>
        </p>
      </div>
    </main>
  </body>
</html>
