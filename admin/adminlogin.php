<?php
$server = 'localhost';
$username = 'root';
$password = '12345';
$database = 'ecom';

$link = "mysql:host=$server;dbname=$database";
$con = new PDO($link,$username,$password);
?>
<?php 
    
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $co = $_POST['code'];
        $searchstmt = $con->prepare("SELECT * FROM admin WHERE password=?");
        $searchstmt->execute([$co]);
        $data = $searchstmt->fetchAll();
        $atoken = rand(111111111111111,999999999999999);
        if ($co==$data[0]['password']){
            setcookie("adminuser", $atoken, time() + (24 * 60 * 60), "/");
            setcookie("adminname", $data[0]['name'], time() + (24 * 60 * 60), "/");

            $setrandm = $con->prepare("UPDATE admin SET token = ? WHERE password = ?");
            $setrandm->execute([$atoken,$co]);

        }else{
            echo 'wrong admin credential';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script> -->
    <title>Document</title>
</head>
<body>
    <?php
        if(isset($_COOKIE['adminuser'])){
            echo '<h1> admin already logged in</h1>';
        }else{
    ?>           
    <fieldset style=" width:fit-content; margin:auto; margin-top:200px;">
        <form action="./adminlogin.php" method="post">
            <input type="password" name="code" placeholder="enter pass" required><br>
            <button type="submit"> submit</button><br>
            <button type="reset"> reset</button><br>
        </form>
    </fieldset>
    <?php } ?>

</body>
</html>
