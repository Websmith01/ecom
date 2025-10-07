<?php
$server = 'localhost';
$username = 'root';
$password = '12345';
$database = 'ecom';

$link = "mysql:host=$server;dbname=$database";
$con = new PDO($link,$username,$password);
?>
<?php
    $id = $_GET['id'];  
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $pn = $_POST['pname'];
        $pp = $_POST['pprice'];
        $pq = $_POST['pqty'];
        $pim = $_POST['imglink'];
        $insertstmt = $con->prepare("UPDATE product SET pname = ?, pprice = ?, pqty = ?, imglink = ? where pid =?");
        try{
            $insertstmt->execute([$pn,$pp,$pq,$pim,$id]);
            echo '<center><h2 style="color: #19183b;">Updated Successfully</h2></center>';
        }catch (PDOException $e) {
            echo 'Error occurred: ' . $e->getMessage();
        }
    }
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./updateprod.css">
</head>
<body>
    <a href="../admin/mainadmin.php"><button>Back</button></a>
     <?php
        $auth = false;
        if(!isset($_COOKIE['adminuser'])){
            echo '<h1> admin login 1st <a href="./adminlogin.php">go to login page</a></h1>';
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
        
        $prodsql =$con->prepare("SELECT * FROM product WHERE pid = ?");
        $prodsql->execute([$id]);
        $prod = $prodsql->fetchAll();
?>

    <form action="<?php echo './updateprod.php?id=' . $id; ?>" method="post">
        <h1>UPDATE PRODUCT</h1>
        <input type="text" value="<?php echo $prod[0]['pid'];  ?>" disabled> <br>
        <input type="text" value="<?php echo $prod[0]['pcategory'];  ?>" disabled> <br>
        <input type="text" name="pname" value="<?php echo $prod[0]['pname'];  ?>" > <br>
        <input type="text" name="pprice" value="<?php echo $prod[0]['pprice']; ?>"> <br>
        <input type="text" name="pqty" value="<?php echo $prod[0]['pqty']; ?>"> <br>
        <input type="text" placeholder="IMGLINK" name="imglink" value="<?php echo $prod[0]['imglink']; ?>"> <br>
        <button type="submit">UPDATE</button>
    </form>
<?php } else{
    echo 'some error occured';
    }
?>
</body>
</html>