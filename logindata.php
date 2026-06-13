<?php
session_start();
include 'db.php';
if(isset($_POST['submit']))
{
    $email=$_POST["email"];
    $password=$_POST["password"];
    $fetchs=$con->prepare("SELECT * FROM user WHERE email=:emails");
    $fetchs->bindParam(':emails',$email);
    $fetchs->execute();
    if($fetch=$fetchs->fetch()){
        if(password_verify($password,$fetch['password'])){
            $_SESSION["user_email"]=$email;
            $_SESSION["user_id"]=$fetch['id'];
            $_SESSION["role"]=$fetch['role'];
        if($fetch['role']=="admin"){
            header("location:admindashboard.php");
            exit();
        }else{header("location:userdashboard.php");
        exit();
        }
        }
        else{
            $_SESSION["wrong"]="<div class='alert alert-danger' role='alert'>
   Incorrect Passwords!
</div>";
        }
    }
    else{
        $_SESSION["wrong"]="<div class='alert alert-danger' role='alert'>
  User not found!
</div>";
    }


header("location:login.php");

}

?>