<?php
$host="localhost";
$dbname="ecommerce";
$user="root";
$password="";
$optione=[pdo::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES UTF8"];
$dsn="mysql:host=$host;dbname=$dbname";

try{
    $conn= new pdo($dsn,$user,$password,$optione);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $err){
 echo "error in conection" . $err->getMessage(); 
}