<?php

require_once('connection.php');

  try{
  $sql = "CREATE TABLE Accounts (
  user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(50) NOT NULL,
  user_email VARCHAR(50) NOT NULL,
  password VARCHAR(50) NOT NULL
  )";

  
  echo "Table Accounts";
} catch (PDOException $e){
  echo $sql. "<br>" . $e->getMessage();
}

$conn = null;
?>