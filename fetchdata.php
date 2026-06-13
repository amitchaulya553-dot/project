<?php 
session_start();
include 'db.php';
if(isset($_POST['submit'])){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $fetch=$con->prepare("SELECT * FROM user WHERE email=:emails");
    $fetch->bindParam(':emails',$email);
    $fetch->execute();
    

if(empty($username) || empty($email) || empty($password) || empty($confirm_password)){
    $_SESSION['error'] = "<div class='alert alert-danger' role='alert'>
  All fields are required!
</div>";
} elseif($password !== $confirm_password){
    $_SESSION['error'] = "<div class='alert alert-danger' role='alert'>
  Passwords do not match!
</div>";
}elseif(strlen($password)<=5){
  $_SESSION['error'] = "<div class='alert alert-danger' role='alert'>
  Passwords length should above five!
</div>"; 
}
elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "<div class='alert alert-danger' role='alert'>
  Invalid email format!
</div>";
}elseif($fetchs=$fetch->fetch()){
    $_SESSION['error'] = "<div class='alert alert-danger' role='alert'>
  User already exists!
</div>";
}
    else{
        $hash=password_hash($password,PASSWORD_DEFAULT);
        $add=$con->prepare("INSERT INTO user(username,email,password)VALUES(:username,:email,:password)");
        $add->bindParam(':username',$username);
        $add->bindParam(':email',$email);
        $add->bindParam(':password',$hash);
        $add->execute();
         $_SESSION['error'] = "<div class='alert alert-success' role='alert'>
  Registration successful
</div>";
    }
    header("Location: registration.php");
}