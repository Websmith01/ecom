<?php
$server = 'localhost';
$username = 'root';
$password = '12345';
$database = 'ecom';

$link = "mysql:host=$server;dbname=$database";
$con = new PDO($link,$username,$password);
$an='';
if(isset($_COOKIE['adminname'])){
    $an = $_COOKIE['adminname'];
}
$updemail = $con->prepare("UPDATE admin SET token='' WHERE name = ?");
$updemail->execute([$an]);
setcookie("adminuser", "");
header("Location: ./main.php");
exit();
?>