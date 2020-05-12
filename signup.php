<?php
//connect to the db
require_once('connection.php');
//include('insert_account.php');



//global var
$errors = array();
$full_name = "";
$user_email = "";



// if the user clicks on the signup button
if (isset($_POST['signup-btn'])){
$full_name = $_POST['full_name'];
$user_email = $_POST['user_email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

//validation
if(empty($full_name)){
  $errors['full_name'] = "Full name required";
}
//we are using here the php function filter_var and passing the email that we want to validate
//we are using a constant FILTER_VALIDATE_EMAIL to validate the email address
//check more on https://www.w3schools.com/php/filter_validate_email.asp
//if this expression is true, then the email provided from the user is invalid
if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)){ 
  $errors['user_email'] = "Email address is invalid";
}

if(empty($user_email)){
  $errors['user_email'] = "Email required";
}

if(empty($password)){
  $errors['password'] = "Password required";
}

/* if(empty($confirm_password)){
  $errors['confirm_password'] = "Confirm password required";
} */

if($password !== $confirm_password){
  $errors['password'] = "Passwords do not match";
}

// we are connecting to the db(in the beggining of the file) in order to check if the user already exists
//we are using sql statment select to check the accounts table
//if the email address that is equel to the one that the user has had provided
// when we get one result, we stop searching -> LIMIT 1
$emailQuery = "SELECT * FROM Accounts WHERE user_email=? LIMIT 1";
//we have used ? because we are going to use prepare statements
// prepare and bind -> https://www.w3schools.com/php/php_mysql_prepared_statements.asp
//sql statement is created and sent to the db
// the db performs the statement and stores the result without executing it
$statement = $conn->prepare($emailQuery);
//binds the values to one parameter in our case 
$statement->bind_param('s', $user_email);
//and the db executes the statement
$statement->execute();
//we are calling the get result function
$result = $statement->get_result();
//counting the users in order to get a result
$count = $result->number_of_rows;
$statement->close();

if($count > 0){
  $errors['user_email'] = "Email already exsists";
}
 
//if the number of errors is equel to zero, save user to the db
if(count($errors) === 0){
  // md5(Message-Digest Algorithm) is a function that calculates the MD5 hash of a string
  //it also encrypt the password in the db for security reasons
$password = md5($password);
//$password = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO Accounts (full_name, user_email, password) 
              VALUES('$full_name', '$user_email', '$password')";
$statement = $conn->prepare($sql);
$statement->bind_param('sss', $full_name, $user_email, $password);
$statement->execute();
}
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="users.css" />
    <title>Create an account</title>
  </head>
  <body>
    <header>
      <img src="./img/logo.png" alt="logo" />
      <nav>
        <ul>
          <li><a href="#">About</a></li>
          <li><a href="#">Courses</a></li>
          <li><a href="login.php">Login</a></li>
        </ul>
      </nav>
    </header>
    <main>
      <div class="container">
        <h1>Create an account</h1>
        <form method="POST" action="signup.php" value="<?php echo $errors; ?>">
          <input type="text" placeholder="Full Name" name="full_name" value="<?php echo $full_name; ?>" />
          <input type="text" placeholder="Email" name="user_email" value="<?php echo $user_email; ?>" />
          <input type="password" placeholder="Password" name="password"  />
          <input
            type="password"
            placeholder="Confirm Password"
            name="confirm_password" 
            
          />
        </form>
        <p>
          By creating an account you agree to our <br><a style="color: blue;" href="#">Terms of Service and Privacy
          Policy</a>.</br>
        </p>
      </div>
      <button  name="signup-btn" type="submit">SIGN UP</button>
    </main>
  </body>
</html>
