<?php
require '../db.php';
$conn = OpenCon();

if(isset($_POST['submit'])){
  $name = filter_var($_POST['name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  $password = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
  

  $sql = "INSERT INTO user (name, username, password, administrator) VALUES('$name', '$username', '$password', 0)";


  // echo json_encode($_POST);
  try{
    $result = $conn->query($sql);
    header("Location: ../login.php");
    exit();
  }catch(PDOException $e){
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
  }
}


$conn->close();
?>