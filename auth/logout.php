<?php
$server = 'localhost';
$username = 'root';
$password = '12345';
$database = 'ecom';

$link = "mysql:host=$server;dbname=$database";
$con = new PDO($link,$username,$password);
setcookie("herouser", "");
$em='';
if(isset($_COOKIE['heroemail'])){
    $em = $_COOKIE['heroemail'];
}
$updemail = $con->prepare("UPDATE customer SET token='' WHERE email = ?");
$updemail->execute([$em]);
header("Location: ../main.php");
exit();
?>