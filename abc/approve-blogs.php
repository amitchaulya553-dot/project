<?php
session_start();
if($_SESSION["role"]!="admin"){
    header("location:login.php");
    }
    
    include '../db.php';
    $id=$_GET['action'];
   

    $update=$con->prepare("UPDATE blogs SET status='approved' WHERE id=$id");
    $update->execute();
    header("location:/project/pending-blogs.php");
  ?>