<?php
session_start();
if($_SESSION["role"]!="admin"){
    header("location:login.php");
    }
    
    include 'db.php';
    $id=$_GET['action'];
    $reject=$con->prepare("UPDATE blogs SET status='rejected' where id=$id");
    $reject->execute();
    header("location:pending-blogs.php");

    ?>