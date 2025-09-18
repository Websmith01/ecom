<?php
$server = 'localhost';
$username = 'root';
$password = '12345';
$database = 'ecom';

$link = "mysql:host=$server;dbname=$database";
$con = new PDO($link,$username,$password);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./cart.css">
</head>
<body>
   <?php
        $cartcook=$_COOKIE['cartuser'];
        $cart=explode('-',$cartcook);
        print_r($cart);

   ?>
</body>
</html>