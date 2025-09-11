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
</head>
<body>
    <a href="../main.php">home page</a>
    <?php
        $emsql =$con->prepare("SELECT token FROM customer");
        $emsql->execute();
        $user = $emsql->fetchAll();
        $pr = false;
        if(isset($_COOKIE['herouser'])){
            foreach($user as $u){
                // print_r($u);
                if(password_verify($u['token'], $_COOKIE['herouser'])){
                    $pr = true;
                    break;
                }
            }
            if($pr==false){
                echo '<h1>UNAUTHORIZED ACCESS </h1>';
            }
        }else{
            echo '<h1>UNAUTHORIZED ACCESS </h1>';
        }
    ?>
    <?php 
        if($pr == true){

    ?>
    <h1>EDIT PROFILE</h1>
    <fieldset>
    <form action="profile.php" method="post">
        <?php 
            $em = $_COOKIE['heroemail'];
            $emsql =$con->prepare("SELECT user,adr,phno FROM customer WHERE email = ?");
            $emsql->execute([$em]);
            $user = $emsql->fetchAll();
        ?>

        <input type="email" value="<?php echo $em; ?>" disabled><br>
        <input type="text" value="<?php echo $user[0]['user']; ?>" name="username" required placeholder="Username"><br>
        <input type="text" value="<?php echo $user[0]['adr']; ?>" name="address" required placeholder="Address"><br>
        <input type="text" value="<?php echo $user[0]['phno']; ?>" name="phone" required placeholder="Mobile Number"><br>
        <button type="submit">save</button>
    </form></fieldset>
    <?php } ?>
    <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $un = $_POST['username'];
            $adr = $_POST['address'];
            $phno = $_POST['phone'];
            $updsql =$con->prepare("UPDATE customer SET user = ?,adr=?, phno = ? WHERE email=? ");
            $updsql->execute([$un,$adr,$phno,$em]);
            echo 'UPDATED SUCCESSFULLY';
        }
    ?>
</body>
</html>