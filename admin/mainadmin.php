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
    <link rel="stylesheet" href="./mainadmin.css">
</head>
<body>
     <?php
        $auth = false;
        if(!isset($_COOKIE['adminuser'])){
            echo '<h1> admin login 1st <a href="./main.php">go to main page</a></h1>';
        }else{
            $tokensql =$con->prepare("SELECT token FROM admin");
            $tokensql->execute();
            $tokenuser = $tokensql->fetchAll();
            foreach($tokenuser as $tk){
                if($_COOKIE['adminuser'] == $tk['token']){
                    $auth=true;
                    break;
                }
            }
    ?>

    <?php
        }
        if($auth){
    ?>
        <a href="./adminlogin.php">logout admin </a>
        <h4>Authenticated success</h4>
        
        <div class="maindiv">
            <div class="editproduct">
                <div class="producthistory"></div>
                    <div class="addproduct">
                        <form action="">
                            <input type="text" required placeholder="PID"><br>
                            <input type="text" required placeholder="PCATEGORY"><br>
                            <input type="text" required placeholder="PNAME"><br>
                            <input type="text" required placeholder="PPRICE"><br>
                            <input type="text" required placeholder="PQTY"><br>
                            <input type="text" placeholder="imglink"><br>
                            <button type="submit"> Add Product</button>
                            <button type="reset"> RESET</button>
                        </form>
                    </div>
            </div>
            <div class="orderdetail"></div>
        </div>
    <?php }else{
        echo 'un authenticated';
    } ?>
</body>
</html>