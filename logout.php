<?php
session_start();
session_unset();
session_destroy();
setcookie("username","");
setcookie("password","");
header("location:login.php");
?>