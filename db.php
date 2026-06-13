<?php
$host="localhost";
$uesrname="root";
$password="";
$database="project";
try{
    $con= new PDO("mysql:host=$host;dbname=$database", $uesrname, $password);
}
catch(PDOException $e){
    echo "Connection failed: " . $e->getMessage();
}

?>