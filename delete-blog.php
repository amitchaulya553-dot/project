<?php
session_start();
if($_SESSION["role"]!="user"){
    header("location:login.php");
    }
    INCLUDE 'db.php';
    
    $ids = $_GET['id'];
    $fetch=$con->prepare("DELETE FROM blogs WHERE id=:id");
    $fetch->bindParam(':id',$ids);
    $fetch->execute();
    header("location:my-blogs.php");

?>